<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Minutes of Meeting</title>
  <link rel="stylesheet" href="<?php $this->load->view('mom/print/styles.css') ?>">
</head>
<body>

  <header>
    <div style="width: 100%;">
      <center>
        <div style="margin-left: 26px; display: flex; justify-content: center;" align="center">
          <img src="Logo Trusmi Group.png" alt="Gambar" width="50">
          &nbsp;
          &nbsp;
          <span class="header-logo">Minutes of Meeting</span>
        </div>
      </center>
    </div>
  </header>

  <main>
    <section class="content">
      <div class="meeting-info">
        <table width="100%" border="0" cellpadding="4px">
          <tr align="center">
            <td width="33%"><div class="info-label">TANGGAL:</div></td>
            <td width="1%" rowspan="2">
              <div style="background-color: #9E9E9E; height: 50px; border-radius: 7px; width: 2px;">&nbsp;</div>
            </td>
            <td width="33%"><div class="info-label">TEMPAT</div></td>
            <td width="1%" rowspan="2">
              <div style="background-color: #9E9E9E; height: 50px; border-radius: 7px; width: 2px;">&nbsp;</div>
            </td>
            <td width="33%"><div class="info-label">WAKTU</div></td>
          </tr>
          <tr align="center">
            <td class="info-data">
              Senin 11 Dec 2023
            </td>
            <td class="info-data">
              JMP 2
            </td>
            <td class="info-data">
              <span class="label label-outline-primary">14:00 - 17:00</span>
            </td>
          </tr>
        </table>
      </div>
    </section>

    <section class="content">
      <div class="meeting-info">
        <table width="100%" border="0" cellpadding="4px">
          <tr align="center">
            <td colspan="3">
              <span class="info-label">AGENDA RAPAT</span><br>
              <span class="info-data">Penyesuaian report MOM sesuai dengan esensi yang diberikan</span>
            </td>
          </tr>
          <tr align="center">
            <td colspan="3">
              <div style="background-color: #9E9E9E; height: 2px; width: 90%; border-radius: 7px;">&nbsp;</div>
              <br>
            </td>
          </tr>
          <tr align="center">
            <td width="46%">
              <span class="info-label">PEMBAHASAN</span><br>
              <span class="info-data">
                1. Lorem ipsum dolor sit amet, <br>
                2. consectetur adipisicing elit, <br>
                3. sed do eiusmod <br>
                4. tempor incididunt ut labore et dolore magna aliqua.  <br>
                5. Ut enim ad minim veniam, <br>
              </span>
            </td>
            <td width="8%">
              <div style="background-color: #9E9E9E; height: 90px; border-radius: 7px; width: 2px;">&nbsp;</div>
            </td>
            <td width="46%">
              <span class="info-label">PESERTA</span><br>

              <ul class="list-group">
                <li class="list-group-item">
                  <div class="media">
                    <img src="https://trusmiverse.com/hr/uploads/profile/profile_1686212279.jpg" class="mr-3 rounded-circle" alt="Gambar 1" width="50">
                    <span class="info-data" style="padding-top: 5px">Aris</span>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="media">
                    <img src="https://trusmiverse.com/hr/uploads/profile/profile_1686212279.jpg" class="mr-3 rounded-circle" alt="Gambar 2" width="50">
                    <span class="info-data" style="padding-top: 5px">Setiana</span>
                  </div>
                </li>
                <!-- Tambahkan item sesuai kebutuhan -->
              </ul>

            </td>
          </tr>
        </table>
      </div>
    </section>

    <section class="content" style="padding-left: 0px; padding-right: 0px;">
      <div class="meeting-info">

        <table width="100%" class="table table-striped" style="margin-top: 8px;">
          <tr align="center">
            <th colspan="5" style="background-color: #337ab7; color: #fff;"><span class="info-label">Feedback Apps IBR Pro</span></th>
          </tr>
          <tr>
            <td colspan="2"><span class="info-label">ACTION</span></td>
            <td width="15%" align="center"><span class="info-label">KATEGORISASI</span></td>
            <td width="15%" align="center"><span class="info-label">DEADLINE</span></td>
            <td width="15%" align="center"><span class="info-label">PIC</span></td>
          </tr>
          <tr>
            <td><span class="info-data">1</span></td>
            <td><span class="info-data">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
              tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
              quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
              consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
              cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span></td>
            <td align="center"><span class="info-data"><span class="label label-warning">Tasklist</span></span></td>
            <td align="center"><span class="info-data">23 Dec 2023</span></td>
            <td align="center"><span class="info-data">Aris, Fuji, Faisal</span></td>
          </tr>
          <tr>
            <td><span class="info-data">2</span></td>
            <td><span class="info-data">Tampilkan Target vs Actual di dashboard</span></td>
            <td align="center"><span class="info-data"><span class="label label-primary">Statement</span></span></td>
            <td align="center"><span class="info-data">Selesaikan segera</span></td>
            <td align="center"><span class="info-data">Aris, Fuji, Faisal</span></td>
          </tr>
        </table>
      </div>
    </section>


    <!-- <span class="label label-primary">Primary</span>
    <span class="label label-success">Success</span>
    <span class="label label-danger">Danger</span>
    <span class="label label-warning">Warning</span>
    <span class="label label-info">Info</span>



    <span class="label label-outline-primary">Primary</span>
    <span class="label label-outline-secondary">Secondary</span>
    <span class="label label-outline-success">Success</span>
    <span class="label label-outline-danger">Danger</span>
    <span class="label label-outline-warning">Warning</span>
    <span class="label label-outline-info">Info</span>
    <span class="label label-outline-light">Light</span>
    <span class="label label-outline-dark">Dark</span> -->



  </main>

</body>
</html>