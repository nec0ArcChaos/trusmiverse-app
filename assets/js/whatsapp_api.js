function send_wa(list_phone, msg) {
  console.log(list_phone);
  console.log(msg);
  var defer = $.Deferred();
  data = {};
  data["wa"] = [];
  data["phone"] = [];

  total_task = 0;
  total_done = 0;

  $.each(list_phone, function (index, value) {
    value = value
      .toString()
      .split(" ")
      .join("")
      .split("-")
      .join("")
      .split("+")
      .join("");

    if (value.charAt(0) == "0") {
      phone = value.slice(1);
      phone = "62" + phone;
    } else {
      phone = value;
    }

    data["phone"].push(phone);

    total_task++;
  });

  $.each(data["phone"], function (index, value) {
    $.ajax({
      url: "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp",
      type: "POST",
      dataType: "json",
      contentType: "application/json",
      headers: {
        "API-Key":
          "40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1",
      },
      data: JSON.stringify({
        channelID: "2225082380",
        phone: value,
        messageType: "text",
        body: msg,
        withCase: true,
      }),
      async: false,
      success: function (response) {
        if (response.status == 200) {
          new PNotify({
            title: `Success`,
            text: `Whatsapp Terkirim ke nomor ${value}.`,
            icon: "icofont icofont-brand-whatsapp",
            type: "success",
            delay: 2000,
          });
        } else {
          new PNotify({
            title: "Gagal",
            text: `Gagal mengirim pesan ke nomor ${value}.`,
            icon: "icofont icofont-info-circle",
            type: "error",
            delay: 2000,
          });
        }
        data["wa"].push(response);
        total_done++;
      },
      error: function (err) {
        new PNotify({
          title: "Gagal",
          text: `Gagal mengirim pesan ke nomor ${value}.`,
          icon: "icofont icofont-info-circle",
          type: "error",
        });
        data["wa"].push(err);
      },
    });
  });

  data["total_task"] = total_task;
  data["total_done"] = total_done;
  defer.resolve();

  return data;
}

function send_wa_hr(list_phone, msg) {
  console.log(list_phone);
  console.log(msg);
  var defer = $.Deferred();
  data = {};
  data["wa"] = [];
  data["phone"] = [];

  total_task = 0;
  total_done = 0;

  $.each(list_phone, function (index, value) {
    value = value
      .toString()
      .split(" ")
      .join("")
      .split("-")
      .join("")
      .split("+")
      .join("");

    if (value.charAt(0) == "0") {
      phone = value.slice(1);
      phone = "62" + phone;
    } else {
      phone = value;
    }

    data["phone"].push(phone);

    total_task++;
  });

  $.each(data["phone"], function (index, value) {
    $.ajax({
      url: "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp",
      type: "POST",
      dataType: "json",
      contentType: "application/json",
      headers: {
        "API-Key":
          "40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1",
      },
      data: JSON.stringify({
        channelID: "2507194023",
        phone: value,
        messageType: "text",
        body: msg,
        withCase: true,
      }),
      async: false,
      success: function (response) {
        if (response.status == 200) {
          new PNotify({
            title: `Success`,
            text: `Whatsapp Terkirim ke nomor ${value}.`,
            icon: "icofont icofont-brand-whatsapp",
            type: "success",
            delay: 2000,
          });
        } else {
          new PNotify({
            title: "Gagal",
            text: `Gagal mengirim pesan ke nomor ${value}.`,
            icon: "icofont icofont-info-circle",
            type: "error",
            delay: 2000,
          });
        }
        data["wa"].push(response);
        total_done++;
      },
      error: function (err) {
        new PNotify({
          title: "Gagal",
          text: `Gagal mengirim pesan ke nomor ${value}.`,
          icon: "icofont icofont-info-circle",
          type: "error",
        });
        data["wa"].push(err);
      },
    });
  });

  data["total_task"] = total_task;
  data["total_done"] = total_done;
  defer.resolve();

  return data;
}

// function send_whatsapp(phone, msg){

//     $.ajax({
//         url: 'https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp',
//         type: 'POST',
//         dataType: 'json',
//         contentType: 'application/json',
//         headers: {
//         'API-Key': '40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1',
//         },
//         data: JSON.stringify({
//             "channelID": "2225082380",
//             "phone": phone,
//             "messageType": "text",
//             "body": msg,
//             "withCase": true
//         }),
//         success: function(response) {
//             if(response.status == 200){
//                 new PNotify({
//                     title: `Success`,
//                     text: `Whatsapp Terkirim ke nomor ${phone}.`,
//                     icon: 'icofont icofont-brand-whatsapp',
//                     type: 'success'
//                 });
//             }else{
//                 new PNotify({
//                     title: 'Gagal',
//                     text: `Gagal mengirim pesan ke nomor ${phone}.`,
//                     icon: 'icofont icofont-info-circle',
//                     type: 'error'
//                 });
//             }

//             data = response;
//         },
//         error: function(err){
//             new PNotify({
//                 title: 'Gagal',
//                 text: `Gagal mengirim pesan ke nomor ${phone}.`,
//                 icon: 'icofont icofont-info-circle',
//                 type: 'error'
//             });
//             data = err;
//         }
//     });

//     return data;
// }

function send_wa_file(list_phone, type, url, filename, caption) {
  $.each(list_phone, function (index, value) {
    value = value
      .toString()
      .split(" ")
      .join("")
      .split("-")
      .join("")
      .split("+")
      .join("");

    if (value.charAt(0) == "0") {
      phone = value.slice(1);
      phone = "62" + phone;
    } else {
      phone = value;
    }
    send_whatsapp_file(phone, type, url, filename, caption);
  });
}

function send_whatsapp_file(phone, type, url, filename, caption) {
  $.ajax({
    url: "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp",
    type: "POST",
    dataType: "json",
    contentType: "application/json",
    headers: {
      "API-Key":
        "40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1",
    },
    data: JSON.stringify({
      channelID: "2225082380",
      phone: phone,
      messageType: type,
      body: url,
      filename: filename,
      caption: caption,
      withCase: true,
    }),
    success: function (response) {
      if (response.status == 200) {
        new PNotify({
          title: `Success`,
          text: `Whatsapp Terkirim ke nomor ${phone}.`,
          icon: "icofont icofont-brand-whatsapp",
          type: "success",
        });
      } else {
        new PNotify({
          title: "Gagal",
          text: `Gagal mengirim pesan ke nomor ${phone}.`,
          icon: "icofont icofont-info-circle",
          type: "error",
        });
      }
    },
    error: function (err) {
      new PNotify({
        title: "Gagal",
        text: `Gagal mengirim pesan ke nomor ${phone}.`,
        icon: "icofont icofont-info-circle",
        type: "error",
      });
    },
  });
}

function send_wa_trusmi(list_phone, msg, channelID = null) {
  console.log(list_phone);
  console.log(msg);
  var defer = $.Deferred();
  data = {};
  data["wa"] = [];
  data["phone"] = [];

  total_task = 0;
  total_done = 0;

  $.each(list_phone, function (index, value) {
    value = value
      .toString()
      .split(" ")
      .join("")
      .split("-")
      .join("")
      .split("+")
      .join("");

    if (value.charAt(0) == "0") {
      phone = value.slice(1);
      phone = "62" + phone;
    } else {
      phone = value;
    }

    data["phone"].push(phone);

    total_task++;
  });

  $.each(data["phone"], function (index, value) {
    $.ajax({
      url: "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp",
      type: "POST",
      dataType: "json",
      contentType: "application/json",
      headers: {
        "API-Key":
          "40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1",
      },
      data: JSON.stringify({
        // channelID: "2319536345", //0821-1543-2627
        // channelID: "2225082380",
        channelID: channelID == null ? "2225082380" : channelID, // 2225082380 = 0821-1020-5700
        phone: value,
        messageType: "text",
        body: msg,
        withCase: true,
      }),
      async: false,
      success: function (response) {
        if (response.status == 200) {
          new PNotify({
            title: `Success`,
            text: `Whatsapp Terkirim ke nomor ${value}.`,
            icon: "icofont icofont-brand-whatsapp",
            type: "success",
            delay: 2000,
          });
        } else {
          new PNotify({
            title: "Gagal",
            text: `Gagal mengirim pesan ke nomor ${value}.`,
            icon: "icofont icofont-info-circle",
            type: "error",
            delay: 2000,
          });
        }
        data["wa"].push(response);
        total_done++;
      },
      error: function (err) {
        new PNotify({
          title: "Gagal",
          text: `Gagal mengirim pesan ke nomor ${value}.`,
          icon: "icofont icofont-info-circle",
          type: "error",
        });
        data["wa"].push(err);
      },
    });
  });

  data["total_task"] = total_task;
  data["total_done"] = total_done;
  defer.resolve();

  return data;
}

function send_wa_file_trusmi(list_phone, type, url, filename, caption, channelID = null) {
  $.each(list_phone, function (index, value) {
    value = value
      .toString()
      .split(" ")
      .join("")
      .split("-")
      .join("")
      .split("+")
      .join("");

    if (value.charAt(0) == "0") {
      phone = value.slice(1);
      phone = "62" + phone;
    } else {
      phone = value;
    }
    send_whatsapp_file_trusmi(phone, type, url, filename, caption);
  });
}

function send_whatsapp_file_trusmi(phone, type, url, filename, caption) {
  $.ajax({
    url: "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp",
    type: "POST",
    dataType: "json",
    contentType: "application/json",
    headers: {
      "API-Key":
        "40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1",
    },
    data: JSON.stringify({
      // channelID: "2319536345", //0821-1543-2627
      channelID: "2507194023",
      phone: phone,
      messageType: type,
      body: url,
      filename: filename,
      caption: caption,
      withCase: true,
    }),
    success: function (response) {
      if (response.status == 200) {
        new PNotify({
          title: `Success`,
          text: `Whatsapp Terkirim ke nomor ${phone}.`,
          icon: "icofont icofont-brand-whatsapp",
          type: "success",
        });
      } else {
        new PNotify({
          title: "Gagal",
          text: `Gagal mengirim pesan ke nomor ${phone}.`,
          icon: "icofont icofont-info-circle",
          type: "error",
        });
      }
    },
    error: function (err) {
      new PNotify({
        title: "Gagal",
        text: `Gagal mengirim pesan ke nomor ${phone}.`,
        icon: "icofont icofont-info-circle",
        type: "error",
      });
    },
  });
}


function send_wa_internal(list_phone, msg, user_id = null) {
  // 1. Inisialisasi
  var defer = $.Deferred(); // Objek deferred untuk mengelola async
  var data = {};
  data["wa"] = []; // Menyimpan semua respons (sukses/gagal)
  data["phone"] = []; // Menyimpan nomor yang sudah dinormalisasi
  var requests = []; // Array untuk menampung semua promise AJAX
  var total_task = 0;

  // 2. Normalisasi Nomor Telepon (Sama seperti kode lama)
  $.each(list_phone, function (index, value) {
    value = value
      .toString()
      .split(" ")
      .join("")
      .split("-")
      .join("")
      .split("+")
      .join("");

    var phone;
    if (value.charAt(0) == "0") {
      phone = value.slice(1);
      phone = "62" + phone;
    } else {
      phone = value;
    }

    data["phone"].push(phone);
    total_task++;
  });

  data["total_task"] = total_task;


  $.each(data["phone"], function (index, phone_value) {

    // Simpan promise dari setiap request AJAX
    var request = $.ajax({
      url: "https://trusmiverse.com/apps/api/send_wa/internal",
      type: "POST",
      dataType: "json",
      data: {
        phone: phone_value,
        msg: msg,
        user_id: user_id,
      },


      success: function (response) {
        if (response.status === 'success') {
          new PNotify({
            title: `Success`,
            text: `Whatsapp Terkirim ke nomor ${phone_value}.`,
            icon: "icofont icofont-brand-whatsapp",
            type: "success",
            delay: 2000,
          });
        } else {
          var error_msg = 'Gagal (Tidak ada pesan)';
          if (response.message) {
            error_msg = (typeof response.message === 'object') ? JSON.stringify(response.message) : String(response.message);
          }

          new PNotify({
            title: "Gagal",
            text: `Gagal mengirim ke ${phone_value}. (Respon: ${error_msg.substring(0, 50)}...)`,
            icon: "icofont icofont-info-circle",
            type: "error",
            delay: 2000,
          });
        }
        data["wa"].push(response); // Simpan respons sukses
      },
      error: function (err) {
        // Ini menangani error jaringan (404, 500, timeout, dll)
        new PNotify({
          title: "Error",
          text: `Gagal mengirim pesan ke ${phone_value}. (Error: ${err.statusText})`,
          icon: "icofont icofont-info-circle",
          type: "error",
        });
        data["wa"].push(err); // Simpan objek error
      },
    });

    requests.push(request); // Tambahkan promise ke daftar
  });

  // 4. Tunggu Semua Selesai
  // $.when akan menunggu semua 'requests' selesai (baik sukses/gagal)
  $.when.apply($, requests).always(function () {
    console.log("Semua proses pengiriman WA selesai.");

    // Hitung jumlah yang selesai (semua yang ada di array 'wa')
    data["total_done"] = data["wa"].length;

    // Selesaikan 'deferred' dan kirimkan 'data'
    defer.resolve(data);
  });

  // 5. Kembalikan Promise
  // Ini akan segera dikembalikan, bahkan sebelum AJAX selesai
  return defer.promise();
}
