<main class="main">
  <div class="container-fluid" style="margin-top: 20px">
    <div class="animated fadeIn">
      <div class="row">
        
        <!-- Вывод всех точек проката -->
        <?php foreach ($rental_points as $point) { ?>
          <div class="col-sm-6 col-lg-3 d-flex align-items-stretch">
            <div class="card text-white bg-primary">
              <div class="card-body pb-0">
                <div class="btn-group float-right">
                  <button class="btn btn-transparent dropdown-toggle p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-settings"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Детали</a>
                    <a class="dropdown-item" href="<?=$rental_host . 'token/' . $point['token']?>">Перейти в точку проката</a>
                    <a class="dropdown-item" href="#">Редактировать точку проката</a>
                    <a class="dropdown-item" href="../controllers/rental_points_delete.php?id=<?php echo $point['id_rent']?>">Удалить точку проката                     
                    </a>
                  </div>
                </div>
                <div class="text-value"><?echo $point["name"]?></div>
                <div><?echo $point["city"]?></div>
                <div><?echo $point["address"]?></div>d
                <div><?echo $point["phone"]?></div>
              </div>
              <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
                <canvas class="chart" id="card-chart1" height="70"></canvas>
              </div>
            </div>
          </div>
        <?php } ?>

        <div class="col-sm-6 col-lg-3 hideAddButton d-flex align-items-stretch add_point">
          <div class="card text-black bg">
            <div class="card-body pb-0">
              <div class="text-value">+</div>
              <div>Добавить точку проката</div>
            </div>
            <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
              <canvas class="chart" id="card-chart4" height="70"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12 col-lg-12 hideForm" style="display: none">
          <div class="card text-black bg" style="background: transparent">
            <div class="card-body pb-0">
              <h5 class="card-title">Добавить точку проката</h5>
              <form action="../controllers/rental_points_add.php" method="post" name="form_new_rental_points">
                <div class="form-group">
                  <label for="newPointName">Название</label>
                  <input type="text" class="form-control" id="newPointName" name="name" placeholder="Название точки проката">
                  <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group">
                  <label for="newPointCity">Город</label>
                  <input type="text" class="form-control" id="newPointCity" name="city" placeholder="Город">
                </div>
                <div class="form-group">
                  <label for="newPointAddress">Адрес</label>
                  <input type="text" class="form-control" id="newPointAddress" name="address" placeholder="Адрес">
                </div>
                <div class="form-group">
                  <label for="newPointPhone">Телефон</label>
                  <input type="text" class="form-control" id="newPointPhone" name="phone" placeholder="Телефон">
                </div>
                <button type="submit" name="btn_submit_new_rental_point" value="save" class="btn btn-primary" style="margin-bottom: 20px">Сохранить</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Скрипт для всплытия формы новой точки проката -->
<script type="text/javascript">
  $(document).ready(function () {
    "use strict";

    $( ".hideAddButton" ).click(function() {
      $(this).hide();
      $(".hideForm").show();
    });
  });
</script>

<style scoped>
  .add_point {
    cursor: pointer;
  }
</style>