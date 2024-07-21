<?php
include 'dbconnect.php'; // Include your database connection file

// Fetch donors
$donors_query = "SELECT * FROM users WHERE donated = 1";
$donors_result = mysqli_query($conn, $donors_query);

// Check if query succeeded
if (!$donors_result) {
    die('Query failed: ' . mysqli_error($conn));
}

$donors_data = mysqli_fetch_all($donors_result, MYSQLI_ASSOC);

// Fetch rejected appointments
$rejected_query = "SELECT * FROM appointments WHERE status = 'rejected'";
$rejected_result = mysqli_query($conn, $rejected_query);

// Check if query succeeded
if (!$rejected_result) {
    die('Query failed: ' . mysqli_error($conn));
}

$rejected_data = mysqli_fetch_all($rejected_result, MYSQLI_ASSOC);

mysqli_close($conn);

// Export options
if (isset($_GET['export'])) {
    $export_type = $_GET['export'];
    
    // Depending on the export type, generate the corresponding file
    switch ($export_type) {
        case 'excel':
            // Generate Excel file
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="donors_and_rejected_appointments.xlsx"');

            // Example: Generating Excel using PHPExcel or PHPSpreadsheet
            // Include necessary libraries and generate Excel content
            // For demonstration, assume generating a simple Excel file
            $excel_output = "ID\tFirst Name\tLast Name\tEmail\tPhone Number\n";
            foreach ($donors_data as $donor) {
                $excel_output .= "{$donor['id']}\t{$donor['first_name']}\t{$donor['last_name']}\t{$donor['email']}\t{$donor['phone_number']}\n";
            }
            foreach ($rejected_data as $rejected) {
                // Assuming structure of appointments table for rejected data
                $excel_output .= "{$rejected['id']}\t{$rejected['appointment_date']}\t{$rejected['appointment_time']}\t{$rejected['reason']}\n";
            }
            echo $excel_output;
            exit();

        case 'pdf':
            // Generate PDF file
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="donors_and_rejected_appointments.pdf"');

            // Example: Generating PDF using TCPDF or FPDF
            // Include necessary libraries and generate PDF content
            // For demonstration, assume generating a simple PDF file
            require_once('tcpdf/tcpdf.php'); // Adjust path as necessary

            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Admin');
            $pdf->SetTitle('Donors and Rejected Appointments Report');
            $pdf->SetMargins(10, 10, 10);
            $pdf->AddPage();
            $pdf->SetFont('helvetica', '', 10);

            // Add content to PDF
            $pdf->Cell(0, 10, 'Donors:', 0, 1);
            foreach ($donors_data as $donor) {
                $pdf->Cell(0, 10, "{$donor['id']}, {$donor['first_name']} {$donor['last_name']}, {$donor['email']}, {$donor['phone_number']}", 0, 1);
            }
            $pdf->Cell(0, 10, 'Rejected Appointments:', 0, 1);
            foreach ($rejected_data as $rejected) {
                $pdf->Cell(0, 10, "{$rejected['id']}, {$rejected['appointment_date']} {$rejected['appointment_time']}, {$rejected['reason']}", 0, 1);
            }

            $pdf->Output('donors_and_rejected_appointments.pdf', 'D');
            exit();

        case 'word':
            // Generate Word file
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment; filename="donors_and_rejected_appointments.docx"');

            // Example: Generating Word using PHPWord
            // Include necessary libraries and generate Word content
            // For demonstration, assume generating a simple Word file

            // Import necessary classes within the correct context
            require_once 'PHPWord/src/PhpWord/Autoloader.php'; // Adjust path as necessary
            
            // Ensure the 'use' statement is inside the context of the PHP script
            

            $phpWord = new PhpWord();
            $section = $phpWord->addSection();
            $section->addText('Donors:');
            foreach ($donors_data as $donor) {
                $section->addText("{$donor['id']}, {$donor['first_name']} {$donor['last_name']}, {$donor['email']}, {$donor['phone_number']}");
            }
            $section->addText('Rejected Appointments:');
            foreach ($rejected_data as $rejected) {
                $section->addText("{$rejected['id']}, {$rejected['appointment_date']} {$rejected['appointment_time']}, {$rejected['reason']}");
            }

            $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save('php://output');
            exit();

        default:
            // Handle unknown export types
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate Reports</title>
</head>
<body>
    <h1>Generate Reports</h1>
    <p>
        <a href="?export=excel">Export as Excel</a> |
        <a href="?export=pdf">Export as PDF</a> |
        <a href="?export=word">Export as Word</a>
    </p>
</body>
</html>
