<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Merger</title>
</head>

<body>
    <?php



    while (ob_get_level())
        ob_end_clean();
    header("Content-Encoding: None", true);



    // import fpdi and fpdf files
    use setasign\Fpdi\Fpdi;

    require_once('fpdf184/fpdf.php');
    require_once('FPDI-2.3.6/src/autoload.php');


    // New Class to Merge PDFs
    class MergePdf extends Fpdi
    {
        public $pdffiles = array();

        public function setFiles($pdffiles)
        {
            $this->pdffiles = $pdffiles;
        }

        // function to merge pdf files using fpdf and fpdi
        public function merge()
        {
            foreach ($this->pdffiles as $file) {
                $pdfCount = $this->setSourceFile($file);
                for ($pdfNo = 1; $pdfNo <= $pdfCount; $pdfNo++) {
                    $pdfId = $this->ImportPage($pdfNo);
                    $temp = $this->getTemplatesize($pdfId);
                    $this->AddPage($temp['orientation'], $temp);
                    $this->useImportedPage($pdfId);
                }
            }
        }
    }

    // Main
    $Outputpdf = new MergePdf();
    $Outputpdf->setFiles(array('C:\xampp\htdocs\pdf_merger\pdfs\TEST_1.pdf', 'C:\xampp\htdocs\pdf_merger\pdfs\TEST_2.pdf'));
    $Outputpdf->merge();

    $Outputpdf->Output('merged.pdf', 'I');
    $Outputpdf->Output('output/merged.pdf', 'F');


    ?>
</body>

</html>