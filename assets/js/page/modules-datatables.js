"use strict";

$("[data-checkboxes]").each(function () {
  var me = $(this),
    group = me.data("checkboxes"),
    role = me.data("checkbox-role");

  me.change(function () {
    var all = $(
        '[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"])'
      ),
      checked = $(
        '[data-checkboxes="' +
          group +
          '"]:not([data-checkbox-role="dad"]):checked'
      ),
      dad = $('[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'),
      total = all.length,
      checked_length = checked.length;

    if (role == "dad") {
      if (me.is(":checked")) {
        all.prop("checked", true);
      } else {
        all.prop("checked", false);
      }
    } else {
      if (checked_length >= total) {
        dad.prop("checked", true);
      } else {
        dad.prop("checked", false);
      }
    }
  });
});

$("#table-1").dataTable({
  language: {
    "emptyTable": "Tabel Kosong",
    "search": "Cari:",
    "paginate": {
      "first": "Pertama",
      "last": "Terakhir",
      "next": "Berikutnya",
      "previous": "Sebelumnya",
    },
    "info": "Menampilkan data dari _START_-_END_ dari jumlah _TOTAL_ data yang tersedia",
    "zeroRecords": "Tidak menemukan data",
    "sLengthMenu": "Tampilkan _MENU_ data yang ada"
  }
});

$("#table-2").dataTable({
  columnDefs: [{ sortable: false, targets: [0, 2, 3] }],
});
