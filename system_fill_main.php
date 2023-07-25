<?php
require_once("config.php");
require_once("functions.php");
$page_name = "System Fill Main";
$_SESSION['page'] = 'conveyance_pick.php';
login_check();
require_once("assets.php");
?>
<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">
<script>
  let contArr_day = [];
  let modArr_day = [];
  let contArr_night = [];
  let modArr_night = [];
</script>
<style>
  /*header*/
  .header {
    width: 100%;
    height: 30px;
    padding: 20px 5px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #eaecee;
    color: #063c49;
    font-weight: bold;
  }

  .header .date {
    width: 15%;
  }

  .header .build_amount {
    width: 70px
  }

  .header_input::placeholder {
    text-align: start;
    text-indent: 5%;
  }

  input::placeholder {
    color: #063c49;
    font-weight: bold;
    text-align: center;
  }

  /** container-component */

  .container {
    width: 100%;
    display: flex;
    justify-content: space-between;
  }

  /* day */
  .day_container {
    color: #063c49;
    font-weight: bold;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 10px;
  }

  .dayshift {
    font-size: 40px;
    font-family: sans-serif;
  }

  .box {
    display: flex;
    justify-content: space-around;
    text-align: center;
  }

  .box_1 {
    margin-right: 20px;
  }

  .square_box {
    display: flex;
    justify-content: space-between;
  }

  .square_box label {
    font-size: 12px;
  }

  .col {
    border: 1px solid gray;
    width: 80px;
    margin: 5px
  }

  .col .time {
    font-size: 25px;
  }

  /* content */
  .content {
    width: 100%
  }

  table {
    border-collapse: collapse;
    text-align: center;
  }

  tr,
  th,
  td {
    border: 1px solid black;
    padding: 10px 10px;
  }

  .left_side {
    display: block;
    width: 47%;
  }

  /* customize some tags */
  label {
    display: unset;
  }

  .bootstrap-datetimepicker-widget>table thead th {
    background: #fff;
  }
</style>


<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/moment/moment.min.js"></script>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/js/adminlte.min.js"></script>
<script src="assets/js/custom.js"></script>

<body class="hold-transition sidebar-collapse layout-top-nav" onload="startTime()">
  <div class="wrapper">
    <?php include("header.php"); ?>
    <?php include("menu.php"); ?>
    <?php include("latest_updated.php"); ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1 class="m-0" style="display: inline"><?php echo $page_name; ?></h1>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">

              <div onload="showTime()">
                <div class="header">
                  <script>
                    function showTime() {
                      var date = new Date();
                      var hours = date.getHours();
                      var minutes = date.getMinutes();
                      var seconds = date.getSeconds();
                      var ampm = hours >= 12 ? 'PM' : 'AM';
                      hours = hours % 12;
                      hours = hours ? hours : 12;
                      minutes = minutes < 10 ? '0' + minutes : minutes;
                      seconds = seconds < 10 ? '0' + seconds : seconds;
                      var time = hours + ':' + minutes + ':' + seconds + ' ' + ampm;
                      document.getElementById('present-time').innerHTML = time;
                      setTimeout(showTime, 1000);
                    }
                  </script>
                  <!-- <span id="present-time"></span> -->

                  <input class="form-control" type="text" id="date_picker" name="date_picker" value="<?php echo date('Y-m-d'); ?>" style="display: inline-block; width: 150px;">

                  <div style="display:flex; align-items: center;">
                    <label for="BUILD AMOUNT" style="margin:unset;">BUILD AMOUNT:&nbsp;</label>
                    <input name="BUILD AMOUNT" type="number" id="build_amount" class="form-control" style="width:150px;">
                  </div>

                  <input type="text" placeholder="INPUT" class="form-control" style="width:250px;" id="cont_mod">
                  <div class="row m-0 p-0 finish-box">
                    <div class="col-md-12 align-items-center" style="display: flex; height: 40px; text-align: center">
                      <div class="text-center" style="width: 100%; font-size: 24px; font-weight: 600;">
                        <button type="button" class="btn btn-secondary">
                          <?php echo $_SESSION['user']['username'] ?>
                        </button>
                        <button type="button" class="btn" style="background-color: grey;">
                          <a href="logout.php" style="color:white"> LOGOUT</a>
                        </button>
                      </div>
                    </div>
                  </div>
                  <button onclick="exportToExcel()"><img src="assets/img/excel-download.png" alt="report" width="30px" height="30px" /></button>
                  <script>
                    function exportToExcel() {
                      var data = {
                        'day': getTableData('dayShiftTB'),
                        'night': getTableData('nightShiftTB')
                      };
                      console.log(data);
                      $.ajax({
                        url: 'system_excel_export.php',
                        type: 'post',
                        data: data,
                        success: function(res) {
                          // Create a link to download the CSV file as an Excel file
                          var link = document.createElement("a");
                          link.href = './' + res;
                          link.download = res;
                          document.body.appendChild(link);
                          link.click();
                          document.body.removeChild(link);
                          deleteFile(res);
                        }
                      })
                    }
                  </script>
                  <div>
                    <label for="last_uploaded">Last Uploaded: &nbsp;</label>
                    <?php
                    if ($latest_updated === NULL) {
                      echo "No data";
                    } else echo $latest_updated["Update_time"];
                    ?>
                  </div>
                </div>
                <div class="container" id="ExcelData">
                  <div class="left_side">
                    <div class="day_container">
                      <div><Label class="dayshift">DAYSHIFT</Label>
                      </div>
                      <div class="box">
                        <div class="right_box box_1">
                          <div><label for="" class="title">Ave.Sets/Module</label></div>
                          <div class="square_box">
                            <div class="square_box1 col">
                              <label for="">TARGET</label><br>
                              <label for="" class="time">00:00</label>
                            </div>
                            <div class=" square_box2 col">
                              <label for="">LIVE</label><br>
                              <label for="" class="time">00:00</label>
                            </div>
                          </div>
                        </div>
                        <div class="right_box box_2">
                          <label for="" class="title">Ave.Sets/Module</label>
                          <div class="square_box">
                            <div class="square_box1 col">
                              <label for="">TARGET</label><br>
                              <label for="" class="time">00:00</label>
                            </div>
                            <div class=" square_box2 col">
                              <label for="">LIVE</label><br>
                              <label for="" class="time">00:00</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="content day_table" id="table_data">

                    </div>
                    <script>
                      let previousObj = [];
                      const rows = $("table tr");
                      rows.each(function(i, el) {
                        let obj = [];
                        $(el).children("td").each(function(ic, elc) {
                          obj.push(elc);

                          if (previousObj.length > ic) {
                            if (previousObj[ic].innerHTML == obj[ic]
                              .innerHTML) {
                              $(previousObj[ic]).attr('rowspan',
                                getRowsSpan(ic, i, obj[ic]
                                  .innerHTML));
                              $(obj[ic]).remove();
                            }
                          }
                        });

                        previousObj = obj;
                      });

                      function getRowsSpan(col, row, value) {
                        var rowSpan = 2;
                        var actualRow = row + 1;

                        while ($(rows[actualRow]).children("td")[col].innerHTML == value) {
                          rowSpan++;
                          actualRow++;
                        }

                        return rowSpan;
                      }
                    </script>
                  </div>
                  <div class="left_side">
                    <div class="day_container">
                      <div><Label class="dayshift">NIGHTSHIFT</Label>
                      </div>
                      <div class="box">
                        <div class="right_box box_1">
                          <div><label for="" class="title">Ave.Sets/Module</label></div>
                          <div class="square_box">
                            <div class="square_box1 col">
                              <label for="">TARGET</label><br>
                              <label for="" class="time">00:00</label>
                            </div>
                            <div class=" square_box2 col">
                              <label for="">LIVE</label><br>
                              <label for="" class="time">00:00</label>
                            </div>
                          </div>
                        </div>
                        <div class="right_box box_2">
                          <label for="" class="title">Ave.Sets/Module</label>
                          <div class="square_box">
                            <div class="square_box1 col">
                              <label for="">TARGET</label><br>
                              <label for="" class="time">00:00</label>
                            </div>
                            <div class=" square_box2 col">
                              <label for="">LIVE</label><br>
                              <label for="" class="time">00:00</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="content night_table" id="table_data">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-wrapper -->
    <?php include("footer.php"); ?>
  </div>
  <!-- REQUIRED SCRIPTS -->
</body>
<script>
  // document.getElementById("date_picker").valueAsDate = new Date();
  $(document).ready(function() {
    $("#date_picker").datetimepicker({
      format: 'YYYY-MM-DD',
      icons: {
        previous: 'fas fa-angle-left',
        next: 'fas fa-angle-right',
      }
    });
    $("#build_amount").keydown(function(e) {
      if (e.keyCode === 13) {
        let segVal_Day = ($("#build_amount").val() / dayRowNum * 2).toFixed(2);
        let segVal_Night = ($("#build_amount").val() / nightRowNum * 2).toFixed(2);
        for (let i = 1; i <= dayRowNum; i++) {
          $("#day_counter_" + i).text((segVal_Day * (parseInt(i / 2) + 1)).toFixed(2));
        }
        for (let j = 1; j <= nightRowNum; j++) {
          $("#night_counter_" + j).text((segVal_Night * (parseInt(j / 2) + 1)).toFixed(2));
        }
      }
    })

    $("#cont_mod").keydown(function(e) {
      if (e.keyCode === 13) {
        let cont = $("#cont_mod").val().slice(0, 5);
        let mod = $("#cont_mod").val().slice(5);
        let contModStr = $("#cont_mod").val();

        // in case of day shift
        for (let i = 0; i < dayRowNum - 1; i++) {
          let contVal = $($("tr[dayrowid='" + i + "'] td:first")).text();
          let modVal = $($("tr[dayrowid='" + i + "'] td:nth-child(2)")).text();
          if (contModStr.includes(contVal) && contModStr.includes(modVal)) {
            $($("tr[dayrowid='" + i + "'] td:first")).css("background-color", "green");
            $($("tr[dayrowid='" + i + "'] td:nth-child(2)")).css("background-color", "green");
            $($("#dayShiftTB tr")[i + 1]).attr("greenFlag", "1");
            let selRow = $($("#dayShiftTB tr")[i + 1]);
            let loadVal = parseInt($($(selRow).children()[5]).attr("load"));
            let tmpDayRowID = $(selRow).attr("dayrowid");
            let tmpTxt = "<span style='color:#063c49; font-weight:700;'><?php echo $_SESSION['user']['username'] ?></span>";
            let newTime = "<p style='margin:unset;'>" + new Date().getHours() + ":" + new Date().getMinutes() + "</p>";
            if (tmpDayRowID % 2 === 0) {
              let sibling = parseInt(tmpDayRowID) + 1;
              if ($("tr[dayrowid='" + sibling + "']").attr("greenFlag") == "1") {
                $($(selRow).children()[5]).append(tmpTxt, newTime);
                $($(selRow).children()[4]).text(liveVal);
                $($(selRow).children()[4]).attr('status', );
                $($(selRow).children()[4]).attr("daylive", "true");
                var dayStSel = document.getElementById("dayStSel_" + parseInt(i / 2 + 1));
                var dayFnSel = document.getElementById("dayFnSel_" + parseInt(i / 2 + 1));
                dayStSel.disabled = false;
                dayFnSel.disabled = false;
                var startSelectElement = document.getElementById("dayStSel_" + parseInt(i / 2 + 1));
                var finishSelectElement = document.getElementById("dayFnSel_" + parseInt(i / 2 + 1));

                userNames.forEach(function(name) {
                  var option = document.createElement("option");
                  option.text = name;
                  startSelectElement.add(option);

                  var optionClone = option.cloneNode(true);
                  finishSelectElement.add(optionClone);
                });
              }
            } else {
              let sibling = parseInt(tmpDayRowID) - 1;
              if ($("tr[dayrowid='" + sibling + "']").attr("greenFlag") == "1") {
                $($($("tr[dayrowid='" + sibling + "']")).children()[5]).append(tmpTxt, newTime);
                $($($("tr[dayrowid='" + sibling + "']")).children()[4]).text(liveVal);
                $($($("tr[dayrowid='" + sibling + "']")).children()[4]).attr('status', 'updated');
                $($($("tr[dayrowid='" + sibling + "']")).children()[4]).attr("daylive", "true");
                var dayStSel = document.getElementById("dayStSel_" + parseInt(i / 2 + 1));
                var dayFnSel = document.getElementById("dayFnSel_" + parseInt(i / 2 + 1));
                dayStSel.disabled = false;
                dayFnSel.disabled = false;
                var startSelectElement = document.getElementById("dayStSel_" + parseInt(i / 2 + 1));
                var finishSelectElement = document.getElementById("dayFnSel_" + parseInt(i / 2 + 1));

                userNames.forEach(function(name) {
                  var option = document.createElement("option");
                  option.text = name;
                  startSelectElement.add(option);

                  var optionClone = option.cloneNode(true);
                  finishSelectElement.add(optionClone);
                });
              }
            }
            $("#cont_mod").val("");
          }
        }

        // in case of night shift
        for (let i = 0; i < nightRowNum; i++) {
          let contVal = $($("tr[nightrowid='" + i + "'] td:first")).text();
          let modVal = $($("tr[nightrowid='" + i + "'] td:nth-child(2)")).text();
          if (contModStr.includes(contVal) && contModStr.includes(modVal)) {
            $($("tr[nightrowid='" + i + "'] td:first")).css("background-color", "green");
            $($("tr[nightrowid='" + i + "'] td:nth-child(2)")).css("background-color", "green");
            $($("#nightShiftTB tr")[i + 1]).attr("greenFlag", "1");
            let selRow = $($("#nightShiftTB tr")[i + 1]);
            let loadVal = parseInt($($(selRow).children()[5]).attr("load"));
            let tmpDayRowID = $(selRow).attr("nightrowid");
            let tmpTxt = "<span style='color:#063c49; font-weight:700;'><?php echo $_SESSION['user']['username'] ?></span><br/>";
            let newTime = "<p style='margin:unset;'>" + new Date().getHours() + ":" + new Date().getMinutes() + "</p>";
            if (tmpDayRowID % 2 === 0) {
              let sibling = parseInt(tmpDayRowID) + 1;
              if ($("tr[nightrowid='" + sibling + "']").attr("greenFlag") == "1") {
                $($(selRow).children()[5]).append(tmpTxt, newTime);
                $($(selRow).children()[4]).text(liveVal);
                $($(selRow).children()[4]).attr('status', 'updated');
                $($(selRow).children()[4]).attr("daylive", "true");
                var nightStSel = document.getElementById("nightStSel_" + parseInt(i / 2 + 1));
                var nightFnSel = document.getElementById("nightFnSel_" + parseInt(i / 2 + 1));
                nightStSel.disabled = false;
                nightFnSel.disabled = false;
                var startSelectElement = document.getElementById("nightStSel_" + parseInt(i / 2 + 1));
                var finishSelectElement = document.getElementById("nightFnSel_" + parseInt(i / 2 + 1));

                userNames.forEach(function(name) {
                  var option = document.createElement("option");
                  option.text = name;
                  startSelectElement.add(option);

                  var optionClone = option.cloneNode(true);
                  finishSelectElement.add(optionClone);
                });
              }
            } else {
              let sibling = parseInt(tmpDayRowID) - 1;
              if ($("tr[nightrowid='" + sibling + "']").attr("greenFlag") == "1") {
                $($($("tr[nightrowid='" + sibling + "']")).children()[5]).append(tmpTxt, newTime);
                $($($("tr[nightrowid='" + sibling + "']")).children()[4]).text(liveVal);
                $($($("tr[nightrowid='" + sibling + "']")).children()[4]).attr('status', 'updated');
                $($($("tr[nightrowid='" + sibling + "']")).children()[4]).attr("daylive", "true");
                var nightStSel = document.getElementById("nightStSel_" + parseInt(i / 2 + 1));
                var nightFnSel = document.getElementById("nightFnSel_" + parseInt(i / 2 + 1));
                nightStSel.disabled = false;
                nightFnSel.disabled = false;
                var startSelectElement = document.getElementById("nightStSel_" + parseInt(i / 2 + 1));
                var finishSelectElement = document.getElementById("nightFnSel_" + parseInt(i / 2 + 1));

                userNames.forEach(function(name) {
                  var option = document.createElement("option");
                  option.text = name;
                  startSelectElement.add(option);

                  var optionClone = option.cloneNode(true);
                  finishSelectElement.add(optionClone);
                });
              }
            }
            $("#cont_mod").val("");
          }
        }
      }
    })

    // when click Fill Finish select on Day Shift table.
    // $("select[name='Fill Start']").on("change", function() {
    //   console.log($(this));
    // })

    // when click Fill Start select on Day Shift table.
    $("select[name='Day Finish']").on("change", function() {
      // if($(this).parent)
      if ($(this).parent().prev().children("div[name='dayStUser']").text().length > 0) {
        let rowID1 = $(this).parent().parent().attr("id");
        let rowID2 = $('#' + rowID1).next().next().next().attr("id");
        let curretUser = '<?php echo $_SESSION['user']['username'] ?>';
        let liveTime = $(this).parent().prev().prev().children("p").text();
        let liveBuild = $(this).parent().prev().prev().prev().text();
        let startInfo = {
          userName: $(this).parent().prev().children("div[name='dayStUser']").text(),
          regTime: $(this).parent().prev().children("div[name='dayStTime']").text()
        }
        let finishInfo = {
          userName: $(this).prev().prev().text(),
          regTime: $(this).prev().text(),
        }

        let data = {
          firstID: rowID1,
          secondID: rowID2,
          currentUser: curretUser,
          liveTime: liveTime,
          liveBuild: liveBuild,
          startInfo: startInfo,
          finishInfo: finishInfo
        }
        finalData(data);
      } else {
        alert("You didn't select Start Option.");
        return false;
      }
    })

    // when click Fill Start select on Night Shift table.
    $("select[name='Night Finish']").on("change", function() {
      // if($(this).parent)
      if ($(this).parent().prev().children("div[name='nightStUser']").text().length > 0) {
        let rowID1 = $(this).parent().parent().attr("id");
        let rowID2 = $('#' + rowID1).next().next().next().attr("id");
        let curretUser = '<?php echo $_SESSION['user']['username'] ?>';
        let liveTime = $(this).parent().prev().prev().children("p").text();
        let liveBuild = $(this).parent().prev().prev().prev().text();
        let startInfo = {
          userName: $(this).parent().prev().children("div[name='nightStUser']").text(),
          regTime: $(this).parent().prev().children("div[name='nightStTime']").text()
        }
        let finishInfo = {
          userName: $(this).prev().prev().text(),
          regTime: $(this).prev().text(),
        }

        let data = {
          firstID: rowID1,
          secondID: rowID2,
          currentUser: curretUser,
          liveTime: liveTime,
          liveBuild: liveBuild,
          startInfo: startInfo,
          finishInfo: finishInfo
        }
        finalData(data);
      } else {
        alert("You didn't select Start Option.");
        return false;
      }
    })

  })
  finalData();
  setInterval(function() {
    $.ajax({
      url: "./getLatestLive.php",
      type: "get",
      success: (data) => {
        liveVal = JSON.parse(data)[0];
        $("td[status='updated']").text(JSON.parse(data)[0]);
        $("td[status='updated']").text(JSON.parse(data)[0]);
      }
    })
  }, 30000)

  //Select start user name and set it and time for day shift
  function selectDayStName(row) {
    var selectElement = document.getElementById("dayStSel_" + row);
    var selectedValue = selectElement.value;

    var startUserElement = document.getElementById("dayStUser_" + row);
    var startTimeElement = document.getElementById("dayStTime_" + row);

    var username = selectedValue;
    var currentTime = new Date().toLocaleTimeString();

    startUserElement.textContent = username;
    startTimeElement.textContent = currentTime;
  }
  //Select finish user name and set it and time for day shift
  function selectDayFnName(row) {
    var selectElement = document.getElementById("dayFnSel_" + row);
    var selectedValue = selectElement.value;

    var finishUserElement = document.getElementById("dayFnUser_" + row);
    var finishTimeElement = document.getElementById("dayFnTime_" + row);

    var username = selectedValue;
    var currentTime = new Date().toLocaleTimeString();

    finishUserElement.textContent = username;
    finishTimeElement.textContent = currentTime;

  }
  //Select start user name and set it and time for night shift
  function selectNightStName(row) {
    var selectElement = document.getElementById("nightStSel_" + row);
    var selectedValue = selectElement.value;

    var startUserElement = document.getElementById("nightStUser_" + row);
    var startTimeElement = document.getElementById("nightStTime_" + row);

    var username = selectedValue;
    var currentTime = new Date().toLocaleTimeString();

    startUserElement.textContent = username;
    startTimeElement.textContent = currentTime;
  }
  //Select finish user name and set it and time for night shift
  function selectNightFnName(row) {
    var selectElement = document.getElementById("nightFnSel_" + row);
    var selectedValue = selectElement.value;

    var finishUserElement = document.getElementById("nightFnUser_" + row);
    var finishTimeElement = document.getElementById("nightFnTime_" + row);

    var username = selectedValue;
    var currentTime = new Date().toLocaleTimeString();

    finishUserElement.textContent = username;
    finishTimeElement.textContent = currentTime;
  }

  // fetching or saving final data
  function finalData(data) {
    if (data == null) {
      $.ajax({
        url: "finalData.php",
        type: "GET",
        success: (data) => {
          // console.log("this is saved data-->", JSON.parse(data));
          console.log("this is saved data-->", data);
          if (data.length > 0) {
            JSON.parse(data).forEach(function(item) {
              console.log(item);
              $("#" + item.firstID).children(":first").css("background", "green");
              $("#" + item.firstID).children(":nth-child(2)").css("background", "green");
              $("#" + item.secondID).children(":first").css("background", "green");
              $("#" + item.secondID).children(":nth-child(2)").css("background", "green");

              $("#" + item.firstID).children(":nth-child(5)").text(item.liveBuild);

              let tmpTxt = "<span style='color:#063c49; font-weight:700;'>" + item.userNm + "</span><br/>";
              $("#" + item.firstID).children(":nth-child(6)").append(tmpTxt, item.liveTime);

              $("#" + item.firstID).children(":nth-child(7)").children("div:first").append(item.startNm);
              $("#" + item.firstID).children(":nth-child(7)").children("div:nth-child(2)").append(item.startTime);
              // $("#"+item.firstID).children(":nth-child(7)").children("select").prop("disabled", false);

              $("#" + item.firstID).children(":last-child").children("div:first").append(item.finishNm);
              $("#" + item.firstID).children(":last-child").children("div:nth-child(2)").append(item.finishTime);
              // $("#"+item.firstID).children(":last-child").children("select").prop("disabled", false);

            })
          } else {
            console.log("No data");
          }
        }
      })
    } else {
      $.ajax({
        url: "finalData.php",
        type: "POST",
        data: data,
        success: () => {
          alert("Saved data successfully!");
        }
      })
    }
  }

  // 2023-7-20
  function getUsers() {
    $.ajax({
      url: "actions.php",
      method: "post",
      data: {
        action: 'get_users'
      }
    }).done(function(result) {
      console.log("users====>", result);
      var userNames = result;
    });
  }

  function deleteFile(filename) {
    $.ajax({
      url: "actions.php",
      method: "post",
      data: {
        action: 'delete_file',
        file: filename
      }
    })
  }

  function getTableData(table) {
    var rows = [];
    var dataRows = $('#' + table + ' tr');
    for (var i = 1; i < dataRows.length; i++) {
      var row = [];
      if (i == 0)
        var dataCells = dataRows[i].getElementsByTagName("th");
      else
        var dataCells = dataRows[i].getElementsByTagName("td");
      for (var j = 0; j < dataCells.length; j++) {
        row.push(dataCells[j].innerText);
      }
      rows.push(row);
    }
    return rows;
  }

  $('#date_picker').on('dp.change', function(e) {
    read_excel_data($(this).val());
    finalData();
  })

  function read_excel_data(selectedDate) {
    const today = new Date();
    const yyyy = today.getFullYear();
    let mm = today.getMonth() + 1; // Months start at 0!
    let dd = today.getDate();
    let hr = today.getHours();
    let min = today.getMinutes();
    let sec = today.getSeconds();
    const formattedToday = yyyy + '-' + mm + '-' + dd;
    $.ajax({
      url: "actions.php",
      method: "post",
      data: {
        action: 'read_excel',
        date: selectedDate ? selectedDate : formattedToday
      }
    }).done(function(result) {
      var result = JSON.parse(result);
      $('.night_table').html(result.night);
      $('.day_table').html(result.day);
    });
  }

  // Initial function
  read_excel_data();
  getUsers();
</script>

</html>