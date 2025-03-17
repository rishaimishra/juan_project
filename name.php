<?php
// Database credentials
$servername = 'localhost';
$username = 'root';
$password = 'm8dV2x7yq9';
$database = 'bidinline_db';

// Utility function to send JSON responses
function jsonResponse($success, $message = '', $data = []) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data,
    ]);
    exit();
}

// Create a new connection to the database using mysqli
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    jsonResponse(false, 'Database connection failed: ' . $conn->connect_error);
}

// Retrieve POST data
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$dni = $_POST['dni'] ?? 'Na';
$mobile = $_POST['mobile_number'] ?? 'Na';
$company = $_POST['company_number'] ?? 'Na';
$postion = $_POST['position'] ?? 'Na';
$insurance = $_POST['insurance_number'] ?? 'Na';
$license = $_POST['license_number'] ?? 'Na';

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(false, 'Invalid email format.');
}

// Check if email already exists
$checkEmailQuery = 'SELECT id FROM usuarios WHERE email = ?';
if ($stmt = $conn->prepare($checkEmailQuery)) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();
        jsonResponse(false, 'Email already exists. Please use a different email.');
    }
    $stmt->close();
} else {
    jsonResponse(false, 'Failed to prepare SQL statement for checking email.');
}

// Validate password
if (empty($password) || strlen($password) < 8) {
    jsonResponse(false, 'Password must be at least 8 characters long.');
}

// Hash the password
$hashedPassword = $password; // Use a more secure method in production

// Insert user data into the database
$insertUserQuery = "
    INSERT INTO usuarios 
    (`fk_idioma`, `fk_tipo_usuario`, `fk_empresa`, `fk_delegacion`, `email`, `pass`, `nombre`, `apellidos`, `dni`, `movil`, `telefono_empresa`, `cargo`, `volumen_maximo_compra`, `volumen_maximo_venta`, `volumen_minimo_venta`, `fecha`, `timezone`, `ultimo_acceso`, `visitas`, `activo`, `borrado`, `init`, `condiciones`, `invitado`, `fk_invitado`, `insurance_number`, `license_number`)
    VALUES (?, '0', '0', '0', ?, ?, ?, ?, ?, ?, ?, ?, '0', '0', '0', ?, ?, ?, '0', '0', '0', '0', '1', '0', '0', ?, ?)
";

if ($stmt = $conn->prepare($insertUserQuery)) {
    $timezone = date_default_timezone_get();
    $fecha = date('Y-m-d H:i:s');
    $ultimo_acceso = null;

    $stmt->bind_param(
        'ssssssssssssss',
        $_POST['lng'], // fk_idioma
        $email,        // email
        $hashedPassword,
        $_POST['name'],
        $_POST['lastname'],
        $dni,
        $mobile,
        $company,
        $postion,
        $fecha,
        $timezone,
        $ultimo_acceso,
        $insurance,
        $license
    );

    if ($stmt->execute()) {
        $lastInsertId_user = $conn->insert_id;
        $companyName = $_POST['company_name'] ?? 'Na';
        $cif = $_POST['cif'] ?? 'Na';
        $address = $_POST['address'] ?? 'Na';
        $postalCode = $_POST['postal_code'] ?? 'Na';
        $CityName = $_POST['city'] ?? 'Na';
        $countryName = $_POST['country'] ?? 'Na';
        $StateName = $_POST['state'] ?? 'Na';


        // Insert company data
        $insertCompanyQuery = "
            INSERT INTO empresa 
            (`fk_tipo_empresa`, `fk_usuario`, `fk_asociacion`, `nombre`, `cif`, `direccion`, `calle`, `numero`, `cp`, `ciudad`, `fk_pais`, `fk_provincia`, `iniciales`, `volumen_maximo_compra`, `volumen_maximo_venta`, `volumen_minimo_venta`, `hito_pago`, `hito_pago_manual`, `periodo_pago`, `periodo_pago_manual`, `activity_detail1`, `activity_detail2`, `email_facturas`, `invitaciones`, `tipo_empresa_venta`, `area_geografica`, `tipo_bonificacion`, `bono_pagado`, `porcentaje_bonificacion`, `fecha`, `activo`, `borrado`)
            VALUES ('0', ?, '0', ?, ?, ?, '0', '0', ?, ?, ?, ?, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.0000', ?, '0', '0')
        ";

        if ($stmt_company = $conn->prepare($insertCompanyQuery)) {
            $fecha_empressa = date('Y-m-d H:i:s');

            $stmt_company->bind_param(
                'sssssssss',
                $lastInsertId_user,
                $companyName,
                $cif,
                $address,
                $postalCode,
                $CityName,
                $countryName,
                $StateName,
                $fecha_empressa
            );

            if ($stmt_company->execute()) {
                $lastInsertId_empresa = $conn->insert_id;

                // Update user with company ID
                $updateUserQuery = "UPDATE usuarios SET fk_empresa = ? WHERE id = ?";
                if ($stmt_update = $conn->prepare($updateUserQuery)) {
                    $stmt_update->bind_param('ii', $lastInsertId_empresa, $lastInsertId_user);
                    $stmt_update->execute();
                    $stmt_update->close();
                }

                jsonResponse(true, 'User and company created successfully.', [
                    'user_id' => $lastInsertId_user,
                    'company_id' => $lastInsertId_empresa,
                ]);
            } else {
                jsonResponse(false, 'Failed to insert company data: ' . $stmt_company->error);
            }
        } else {
            jsonResponse(false, 'Failed to prepare SQL statement for company data.');
        }
    } else {
        jsonResponse(false, 'Failed to insert user data: ' . $stmt->error);
    }

    $stmt->close();
} else {
    jsonResponse(false, 'Failed to prepare SQL statement for user data.');
}

// Close the database connection
$conn->close();
?>