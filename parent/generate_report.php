<?php
// Start output buffering at the very top of the script
ob_start(); 

session_start();

// Ensure no output before PDF generation
require_once('../includes/db_connect.php');
require_once('../tcpdf/tcpdf.php');

// Check if the user is logged in and has the 'parent' role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'parent') {
    header('Location: ../login.php');
    exit();
}

$parent_id = $_SESSION['user_id'];

// Fetch child's vaccination details
$sql = "SELECT c.name AS child_name, c.dob, v.vaccine_name, vs.scheduled_date, vs.status
        FROM children c
        JOIN vaccinationschedules vs ON c.id = vs.child_id
        JOIN vaccines v ON vs.vaccine_id = v.id
        WHERE c.parent_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $parent_id);
$stmt->execute();
$result = $stmt->get_result();

// Create a new TCPDF instance
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Child Vaccination System');
$pdf->SetTitle('Vaccination Report');
$pdf->SetSubject('Vaccination Report');
$pdf->SetKeywords('Vaccination, Report, PDF');

// Set document information
$pdf->SetHeaderData('', 0, 'Vaccination Report', 'Generated on: ' . date('d M Y'));
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 12));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 10));
$pdf->SetMargins(10, 20, 10);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage();

// Title
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(190, 10, 'Child Vaccination Report', 0, 1, 'C');
$pdf->Ln(5);

// Table Header
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetFillColor(0, 123, 255);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(50, 10, 'Child Name', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'DOB', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Vaccine Name', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Scheduled Date', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Status', 1, 1, 'C', true);

// Reset text color
$pdf->SetTextColor(0, 0, 0);

// Table Data
$pdf->SetFont('helvetica', '', 12);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(50, 10, $row['child_name'], 1);
    $pdf->Cell(30, 10, date("d M Y", strtotime($row['dob'])), 1);
    $pdf->Cell(50, 10, $row['vaccine_name'], 1);
    $pdf->Cell(30, 10, date("d M Y", strtotime($row['scheduled_date'])), 1);
    $pdf->Cell(30, 10, $row['status'], 1, 1);
}

// Clean the output buffer before sending PDF
ob_end_clean();

// Output the PDF as a download (D for download, I for inline display)
$pdf->Output('Vaccination_Report.pdf', 'D');
?>
