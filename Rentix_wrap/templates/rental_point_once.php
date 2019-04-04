<main class="main">
  <div class="container-fluid" style="margin-top: 20px">
    <div class="animated fadeIn">
      <?php print_r($_SESSION) ?>
    </div>
  </div>
</main>

<!-- Скрипт для всплытия формы новой точки проката -->
<!-- <script type="text/javascript">
  $(document).ready(function () {
    "use strict";

    $( ".hideAddButton" ).click(function() {
      $(this).hide();
      $(".hideForm").show();
    });
  });
</script> -->

<style scoped>
  .add_point {
    cursor: pointer;
  }
</style>