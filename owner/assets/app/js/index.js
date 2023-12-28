$(document).ready(function () {
  var table = $("#example").DataTable({
    columns: [
      {
        className: "dt-control",
        orderable: false,
        data: null,
        defaultContent: "",
      },
      {
        data: "idPesanan",
      },
      {
        data: "namaPemesan",
      },
      {
        data: "mulaiSewa",
      },
      {
        data: "akhirSewa",
      },
      {
        data: "action",
      },
      {
        data: "tglPemesanan",
      },
      {
        data: "totalPembayaran",
      },
    ],
    order: [[1, "asc"]],
  });

  function myFunction() {
    var x = document.getElementById("side-nav");
    var y = document.getElementById("side-nav1");
    var a = document.getElementById("main-content-header");
    if (x.style.display === "block") {
      x.style.display = "none";
      y.style.display = "none";
    } else {
      x.style.display = "block";
      y.style.display = "block";
      a.style.width = "none";
    }
  }

  /* Formatting function for row details - modify as you need */
  function format(d) {
    // `d` is the original data object for the row

    const moneyFormat = new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
    });

    const totalPembayaran = moneyFormat.format(d.totalPembayaran);

    return (
      '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
      "<tr>" +
      "<td>Full name:</td>" +
      "<td>" +
      d.namaPemesan +
      "</td>" +
      "</tr>" +
      "<tr>" +
      "<td>Tanggal Pemesanan:</td>" +
      "<td>" +
      d.tglPemesanan +
      "</td>" +
      "</tr>" +
      "<tr>" +
      "<td>Total Pembayaran:</td>" +
      "<td>" +
      `${totalPembayaran}` +
      "</td>" +
      "</tr>" +
      "</table>"
    );
  }

  // Add event listener for opening and closing details
  $("#example tbody").on("click", "td.dt-control", function () {
    var tr = $(this).closest("tr");
    var row = table.row(tr);

    if (row.child.isShown()) {
      // This row is already open - close it
      row.child.hide();
      tr.removeClass("shown");
    } else {
      // Open this row
      row.child(format(row.data())).show();
      tr.addClass("shown");
    }
  });
});
