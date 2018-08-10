<?php
    use \setasign\Fpdi;
    require_once('assets/fpdf/fpdf.php');
    require_once('assets/fpdi/src/autoload.php');

    /**
    * Selected x and y position and convert to pt
    */
    $xPosition = intval(($_POST['x-position'] - 25 ) * 0.75);
    $yPosition = intval(($_POST['y-position'] - 5 ) * 0.75);
    
    /**
    * Reduce x-position if x > 300 and convert to pt
    */
    if($_POST['x-position'] > 300)
    {
        $xPosition = intval(($_POST['x-position'] - 24 ) * 0.75);
    }

    /**
    * Reduce y-position if x > 600 and convert to pt
    */
    if($_POST['y-position'] > 600)
    {
        $yPosition = intval(($_POST['y-position'] - 6 ) * 0.75);
    }

    /**
    * selected box width and height in pt
    */
    $boxWidth = intval($_POST['width']* 0.75);
    $boxHeight = intval($_POST['height'] * 0.75);

    /**
    * link and link-type to insert in selected area
    */
    $linkType = $_POST['link_type'];
    $link = $_POST['link'];

    /**
    * get page number via y-position
    */
    $pageWidth = $_POST['page-width'];
    $pageHeight = 1000;
    $editPageNumber = intval($_POST['y-position'] / $pageHeight) + 1;

    if($editPageNumber > 1 ) 
    {
        /**
        * change y-position if page number > 1 
        */
        $currentPage = $editPageNumber - 1;
        $pageYPosition = $_POST['y-position'] - ( $pageHeight * $currentPage);

        if($pageYPosition > 600 )
        {
            $pageYPosition = $pageYPosition - 6;
            $pageYPosition = intval(($pageYPosition-(6*$editPageNumber)) * 0.75);
        } else {
            $pageYPosition = $pageYPosition;
            $pageYPosition = intval(($pageYPosition-(5*$editPageNumber))* 0.75);
        }
    } else {
        /**
        * calculate actual y-postion in PDF and conver to pt
        */
            $pageYPosition = $yPosition;
    }

    /**
    * FPDI conversion
    */

    // initiate FPDI
    $pdf = new Fpdi\Fpdi('P', 'pt', 'Letter');

    // get the page count
    $pageCount = $pdf->setSourceFile('data/1.pdf');

    // iterate through all pages
    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
        // import a page
        $templateId = $pdf->importPage($pageNo);

        $pdf->AddPage();

        // use the imported page and adjust the page size
        $pdf->useTemplate($templateId, [
            'adjustPageSize' => true, 'width' => 600, 'height' => 750
        ]); 

        // check page number to add link area
        if ($pageNo == 5) {
            $pdf->SetDrawColor(0, 255, 148);
            $pdf->Rect($xPosition, $pageYPosition, $boxWidth, $boxHeight, 'D');
            $pdf->Link($xPosition, $pageYPosition, $boxWidth, $boxHeight, $link);
        }
    }
    $fileName = 'data/test.pdf';
    $pdf->Output();
?>