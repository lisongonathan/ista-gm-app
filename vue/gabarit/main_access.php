<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <title>ISTA-GM/ACCES</title>

  <!-- Favicons -->
  <link href="vue/gabarit/assets/img/favicon.png" rel="icon">
  <link href="vue/gabarit/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="vue/gabarit/assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="vue/gabarit/assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="vue/gabarit/assets/css/zabuto_calendar.css">
  <link rel="stylesheet" type="text/css" href="vue/gabarit/assets/lib/gritter/css/jquery.gritter.css" />
  <!-- Custom styles for this template -->
  <link href="vue/gabarit/assets/css/style.css" rel="stylesheet">
  <link href="vue/gabarit/assets/css/style-responsive.css" rel="stylesheet">
</head>

<body>
  <section id="container">

    <?php echo $contenu; ?>

  </section>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="vue/gabarit/assets/lib/jquery/jquery.min.js"></script>

  <script src="vue/gabarit/assets/lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="vue/gabarit/assets/lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="vue/gabarit/assets/lib/jquery.scrollTo.min.js"></script>
  <script src="vue/gabarit/assets/lib/jquery.nicescroll.js" type="text/javascript"></script>
  <script src="vue/gabarit/assets/lib/jquery.sparkline.js"></script>
  <!--common script for all pages-->
  <script src="vue/gabarit/assets/lib/common-scripts.js"></script>
  <script type="text/javascript" src="vue/gabarit/assets/lib/gritter/js/jquery.gritter.js"></script>
  <script type="text/javascript" src="vue/gabarit/assets/lib/gritter-conf.js"></script>
  <!--script for this page-->
  <script src="vue/gabarit/assets/lib/sparkline-chart.js"></script>
  <script src="vue/gabarit/assets/lib/zabuto_calendar.js"></script>
  <script src="controleur/js/fiche.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script>
    $(document).ready(function(){
      require(["jspdf"], ({ jsPDF }) => {
        const doc = new jsPDF();
        doc.text("Hello world!", 10, 10);
        doc.save("a4.pdf");
      });

      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();
      doc.text("Hello world!", 10, 10);
      doc.save("a4.pdf");

      import { jsPDF } from "jspdf";
      // Default export is a4 paper, portrait, using millimeters for units
      const doc = new jsPDF();

      doc.text("Hello world!", 10, 10);
      doc.save("a4.pdf");
    })
  </script>
</html>
