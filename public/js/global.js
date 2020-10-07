$(document).ready(function() {
    $("select").select2();

    $("#check_all").on("click", function(e) {
        $(".check_item").each(function(i) {
            $(this).prop("checked", e.target.checked);
        });
    });

    $(".input-daterange").datepicker({ format: "dd/mm/yyyy" });

    var dt = $("#datatable").DataTable({
        lengthMenu: [
            [100, 200, 500],
            [100, 200, 500]
        ],
        scrollX: true,
        scrollY: $(window).height() - 255,
        scrollCollapse: true,
        autoWidth: false,
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: [0, 1]
            }
        ],
        order: [[2, "asc"]]
    });

    dt.on("order.dt search.dt", function() {
        dt.column(1, { search: "applied", order: "applied" })
            .nodes()
            .each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
    }).draw();

    $("input,textarea").on("input blur paste", function() {
        var value = $(this).val();
        if (value == "") {
            $(this).css("background-color", "white");
        } else {
            $(this).css("background-color", "#b9cae6");
        }
    });

    $("select").on("change", function() {
        var value = $(this).val();
        if (value == "") {
            $(this)
                .parent()
                .css("background-color", "white");
        } else {
            $(this)
                .parent()
                .find(".select2-container")
                .children()
                .children()
                .css("background-color", "#b9cae6");
        }
    });
});

// pop up pdf
function tampilLampiran(url, title) {
    // alert('dumbass');
    $("#modalLampiran").modal("show");
    $("#iframeLampiran").attr("src", url);
    // $('#lampiranTitle').text(title);
    $("#lampiranTitle").html(
        ` <a href="` + url + `" target="_blank" > ` + title + ` </a> `
    );
}

// pop up foto
function tampilFoto(url, title) {
    // alert('dumbass');
    $("#modalFoto").modal("show");
    $("#imgFoto").attr("src", url);
    // $('#iframeLampiran').attr('src', url);
    $("#lampiranTitle").html(
        ` <a href="` + url + `" target="_blank" > ` + title + ` </a> `
    );
}

// pop up foto absen
function tampilFotoAbsen(url, title, nama, instansi, jam) {
    // alert('dumbass');
    $("#modalFoto").modal("show");
    $("#imgFoto").attr("src", url);
    $("#nama").html(nama);
    $("#instansi").html(instansi);
    $("#jam").html(jam);
    $("#lampiranTitle").html(
        ` <a href="` + url + `" target="_blank" > ` + title + ` </a> `
    );
}

// fungsi ajax untuk chained of provinsi
function chainedProvinsi(url, id_prov, id_kota, placeholder) {
    var prov = $("#" + id_prov).val();
    var kota = $("#" + id_kota).val();

    $("#" + id_kota).empty();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: url,
        method: "GET",
        success: function(datapro) {
            $("#" + id_kota).html(
                "<option value='' selected>" + placeholder + "</option>"
            );
            $("#" + id_kota)
                .select2({
                    data: datapro
                })
                .val(null)
                .trigger("change");
        },
        error: function(xhr, status) {
            alert("terjadi error ketika menampilkan data kota");
            console.log(xhr);
        }
    });
}

// fungsi ajax untuk chained of provinsi filter
function chainedProvinsiFilter(url, id_prov, id_kota, placeholder) {
    var prov = $("#" + id_prov).val();
    var kota = $("#" + id_kota).val();

    $("#" + id_kota).empty();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: url,
        method: "POST",
        data: {
            prov: prov,
            kota: kota
        },
        success: function(datapro) {
            $("#" + id_kota).html(
                "<option value='' selected>" + placeholder + "</option>"
            );
            $("#" + id_kota)
                .select2({
                    data: datapro
                })
                .val(null)
                .trigger("change");
        },
        error: function(xhr, status) {
            alert("terjadi error ketika menampilkan data kota");
            console.log(xhr);
        }
    });
}

// fungsi ajax untuk chained of provinsi filter
function chainedProvinsiKantor(url, id_prov, id_kota, placeholder) {
    var prov = $("#" + id_prov).val();
    var kota = $("#" + id_kota).val();

    $("#" + id_kota).empty();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: url,
        method: "POST",
        data: {
            prov: prov,
            kota: kota
        },
        success: function(datapro) {
            $("#" + id_kota).html(
                "<option value='' selected>" + placeholder + "</option>"
            );
            $("#" + id_kota)
                .select2({
                    data: datapro
                })
                .val(null)
                .trigger("change");
        },
        error: function(xhr, status) {
            alert("terjadi error ketika menampilkan data kota");
            console.log(xhr);
        }
    });
}

// fungsi ajax untuk chained of provinsi filter
function chainedProvinsiBu(url, id_prov, id_kota, placeholder) {
    var prov = $("#" + id_prov).val();
    var kota = $("#" + id_kota).val();

    $("#" + id_kota).empty();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: url,
        method: "POST",
        data: {
            prov: prov,
            kota: kota
        },
        success: function(datapro) {
            $("#" + id_kota).html(
                "<option value='' selected>" + placeholder + "</option>"
            );
            $("#" + id_kota)
                .select2({
                    data: datapro
                })
                .val(null)
                .trigger("change");
        },
        error: function(xhr, status) {
            alert("terjadi error ketika menampilkan data kota");
            console.log(xhr);
        }
    });
}

// fungsi ajax untuk chained of provinsi filter
function chainedProvinsiPersonil(url, id_prov, id_kota, placeholder) {
    var prov = $("#" + id_prov).val();
    var kota = $("#" + id_kota).val();

    $("#" + id_kota).empty();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: url,
        method: "POST",
        data: {
            prov: prov,
            kota: kota
        },
        success: function(datapro) {
            $("#" + id_kota).html(
                "<option value='' selected>" + placeholder + "</option>"
            );
            $("#" + id_kota)
                .select2({
                    data: datapro
                })
                .val(null)
                .trigger("change");
        },
        error: function(xhr, status) {
            alert("terjadi error ketika menampilkan data kota");
            console.log(xhr);
        }
    });
}

// fungsi ajax untuk chained of provinsi filter
function chainedProvinsiDokpersonil(url, id_prov, id_kota, placeholder) {
    var prov = $("#" + id_prov).val();
    var kota = $("#" + id_kota).val();

    $("#" + id_kota).empty();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: url,
        method: "POST",
        data: {
            prov: prov,
            kota: kota
        },
        success: function(datapro) {
            $("#" + id_kota).html(
                "<option value='' selected>" + placeholder + "</option>"
            );
            $("#" + id_kota)
                .select2({
                    data: datapro
                })
                .val(null)
                .trigger("change");
        },
        error: function(xhr, status) {
            alert("terjadi error ketika menampilkan data kota");
            console.log(xhr);
        }
    });
}

// fungsi ajax untuk chained of provinsi filter
function chainedProvinsiTimP(url, id_prov, id_kota, placeholder) {
    var prov = $("#" + id_prov).val();
    var kota = $("#" + id_kota).val();

    $("#" + id_kota).empty();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: url,
        method: "POST",
        data: {
            prov: prov,
            kota: kota
        },
        success: function(datapro) {
            $("#" + id_kota).html(
                "<option value='' selected>" + placeholder + "</option>"
            );
            $("#" + id_kota)
                .select2({
                    data: datapro
                })
                .val(null)
                .trigger("change");
        },
        error: function(xhr, status) {
            alert("terjadi error ketika menampilkan data kota");
            console.log(xhr);
        }
    });
}

function chainedProvinsiTimM(url, id_prov, id_kota, placeholder) {
    var prov = $("#" + id_prov).val();
    var kota = $("#" + id_kota).val();

    $("#" + id_kota).empty();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: url,
        method: "POST",
        data: {
            prov: prov,
            kota: kota
        },
        success: function(datapro) {
            $("#" + id_kota).html(
                "<option value='' selected>" + placeholder + "</option>"
            );
            $("#" + id_kota)
                .select2({
                    data: datapro
                })
                .val(null)
                .trigger("change");
        },
        error: function(xhr, status) {
            alert("terjadi error ketika menampilkan data kota");
            console.log(xhr);
        }
    });
}

// fungsi ajax untuk chained of Jenis Narsum
function chainedJenisNarsum(url, jenis_narsum, nama_narsum, placeholder) {
    var jenis_narsum = $("#" + jenis_narsum).val();
    // var nama_narsum = $('#' + nama_narsum).val();

    $("#" + nama_narsum).empty();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: url,
        method: "POST",
        data: {
            jenis_narsum: jenis_narsum,
            nama_narsum: nama_narsum
        },
        success: function(datapro) {
            console.log(nama_narsum);
            $("#" + nama_narsum).html(
                "<option value='' selected>" + placeholder + "</option>"
            );
            $("#" + nama_narsum)
                .select2({
                    data: datapro
                })
                .val(null)
                .trigger("change");
        },
        error: function(xhr, status) {
            alert("terjadi error ketika menampilkan data kota");
            console.log(xhr);
        }
    });
}

// fungsi ajax untuk chained of Bidang
function chainedFilterBidang(url, bidang, pembinaan, placeholder) {
    var bidang = $("#" + bidang).val();
    // var nama_narsum = $('#' + nama_narsum).val();

    $("#" + pembinaan).empty();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: url,
        method: "POST",
        data: {
            bidang: bidang,
            pembinaan: pembinaan
        },
        success: function(datapro) {
            $("#" + pembinaan).html(
                "<option value='' selected>" + placeholder + "</option>"
            );
            $("#" + pembinaan)
                .select2({
                    data: datapro
                })
                .val(null)
                .trigger("change");
        },
        error: function(xhr, status) {
            alert("terjadi error ketika menampilkan data kota");
            console.log(xhr);
        }
    });
}

// fungsi ajax untuk chained of kota
function chainedKota(url, id_prov, id_kota) {
    var kota = $("#" + id_kota).val();
    var formData = new FormData($("#formRegist")[0]);
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: url,
        method: "POST",
        data: {
            kota: kota
        },
        success: function(datapro) {
            //console.log(datapro[0].provinsi_id);
            $("#" + id_prov)
                .val(datapro[0].provinsi_id)
                .trigger("change");
        },
        error: function(xhr, status) {
            alert("terjadi error ketika menampilkan data provinsi");
        }
    });
}

// Fungsi merubah tanggal ke format indonesia javascript format YYYY-MM-DD
function tanggal_indonesia(string) {
    bulanIndo = [
        "",
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
    ];

    tanggal = string.split("-")[2];
    bulan = string.split("-")[1];
    tahun = string.split("-")[0];

    return tanggal + " " + bulanIndo[Math.abs(bulan)] + " " + tahun;
}

// Fungsi Cek nilai value kosong/NULL atau tidak
function cekNull(value) {
    return value == null || value == "null" ? "" : value;
}

// Fungsi Rubah warna filter
function selectFilter(name) {
    $("#" + name).on("change", function() {
        idfilter = $(this).attr("id");
        if ($(this).val() == "" || $(this).val() == null) {
            $("#select2-" + idfilter + "-container")
                .parent()
                .css("background-color", "transparent");
            $("#select2-" + idfilter + "-container")
                .parent()
                .css("font-weight", "unset");
        } else {
            $("#select2-" + idfilter + "-container")
                .parent()
                .css("background-color", "#b6f38f");
            $("#select2-" + idfilter + "-container")
                .parent()
                .css("font-weight", "bold");
        }
    });
}

// Fungsi Rubah warna filter
function inputFilter(name) {
    $("#" + name).on("change", function() {
        idfilter = $(this).attr("id");
        if ($(this).val() == "") {
            $(this).css("background-color", "transparent");
            $(this).css("font-weight", "unset");
        } else {
            $(this).css("background-color", "#b6f38f");
            $(this).css("font-weight", "bold");
        }
    });
}

// Fungsi merubah Cache warna filter input tipe select2
function selectFilterCache(name) {
    $("#select2-" + name + "-container")
        .parent()
        .css("background-color", "#b6f38f");
    $("#select2-" + name + "-container")
        .parent()
        .css("font-weight", "bold");
}

// Fungsi merubah Cache warna filter input biasa
function inputFilterCache(name) {
    $("#" + name).css("background-color", "#b6f38f");
    $("#" + name).css("font-weight", "bold");
}

// Fungsi Rubah warna filter
function inputFilter(name) {
    $("#" + name).on("input blur paste change", function() {
        idfilter = $(this).attr("id");
        if ($(this).val() == "") {
            $(this).css("background-color", "transparent");
            $(this).css("font-weight", "unset");
        } else {
            $(this).css("background-color", "#b6f38f");
            $(this).css("font-weight", "bold");
        }
    });
}

// Fungsi merubah Cache warna filter input tipe select2
function selectFilterCache(name) {
    $("#select2-" + name + "-container")
        .parent()
        .css("background-color", "#b6f38f");
    $("#select2-" + name + "-container")
        .parent()
        .css("font-weight", "bold");
}

// Fungsi merubah Cache warna filter input biasa
function inputFilterCache(name) {
    $("#" + name).css("background-color", "#b6f38f");
    $("#" + name).css("font-weight", "bold");
}

// fungsi ajax untuk chained of bidnag ke sertitikat alat
function chainedJenisUsaha(url, id_jenis_usaha, id_bidang, placeholder) {
    var jenisusaha = $("#" + id_jenis_usaha).val();
    var bidang = $("#" + id_bidang).val();

    $("#" + id_bidang).empty();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: url,
        method: "POST",
        data: {
            jenisusaha: jenisusaha,
            bidang: bidang
        },
        success: function(data) {
            $("#" + id_bidang).html(
                "<option value='' selected>" + placeholder + "</option>"
            );
            $("#" + id_bidang)
                .select2({
                    data: data
                })
                .val(null)
                .trigger("change");
        },
        error: function(xhr, status) {
            alert("terjadi error ketika menampilkan data");
            console.log(xhr);
        }
    });
}

// fungsi ajax untuk chained of bidnag ke sertitikat alat
function chainedBidang(url, id_bidang, id_sertifikat_alat, placeholder) {
    var bid = $("#" + id_bidang).val();
    var sertf_alat = $("#" + id_sertifikat_alat).val();

    $("#" + id_sertifikat_alat).empty();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: url,
        method: "POST",
        data: {
            bid: bid,
            sertf_alat: sertf_alat
        },
        success: function(data) {
            $("#" + id_sertifikat_alat).html(
                "<option value='' selected>" + placeholder + "</option>"
            );
            $("#" + id_sertifikat_alat)
                .select2({
                    data: data
                })
                .val(null)
                .trigger("change");
        },
        error: function(xhr, status) {
            alert("terjadi error ketika menampilkan data");
            console.log(xhr);
        }
    });
}

function setDateRangePicker(input1, input2) {
    $(input1)
        .datepicker({
            autoclose: true,
            format: "dd/mm/yyyy"
        })
        .on("change", function() {
            $(input2)
                .val("")
                .datepicker("setStartDate", $(this).val());
        })
        .css({
            cursor: "pointer",
            background: "white"
        });
    $(input2)
        .datepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            orientation: "top left"
        })
        .css({
            cursor: "pointer",
            background: "white"
        });
}

// Fungsi ajax untuk chained of negara
function chainedNegara(url, idnegara, idprov, placeholder) {
    var idnegara = $("#" + idnegara).val();
    url = url + idnegara;

    $("#" + idprov).empty();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: url,
        method: "POST",
        data: {
            id: idnegara
        },
        success: function(data) {
            $("#" + idprov).html(
                "<option value='' selected>" + placeholder + "</option>"
            );
            $("#" + idprov)
                .select2({
                    data: data
                })
                .val(null)
                .trigger("change");
        },
        error: function(xhr, status) {
            alert("terjadi error ketika menampilkan data");
        }
    });
}

function goBack() {
    window.history.back();
}

function capitalizeFirstLetter(string) {
    if (string == null) {
        return "";
    } else {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
}

function changepersonil(id_personil, id_nama, id_jab, id_hp, id_email, url) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: url,
        method: "POST",
        data: {
            id_personil: id_personil
        },
        beforeSend: function() {
            $.LoadingOverlay("show", {
                image: "",
                fontawesome: "fa fa-refresh fa-spin",
                fontawesomeColor: "black",
                fade: [5, 5],
                background: "rgba(60, 60, 60, 0.4)"
            });
        },
        success: function(data) {
            $("#" + id_hp).val(data[0]["hp_wa"]);
            $("#" + id_email).val(data[0]["email_p"]);
            $("#" + id_jab).val("");
        },
        error: function(xhr, status) {
            alert("Error");
        },
        complete: function() {
            $.LoadingOverlay("hide");
        }
    });
}

function isNumberKey(evt) {
    var charCode = evt.which ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
    return true;
}

function sugestPersonil(id_nama_p, id_hp_p, id_email_p, url) {
    $("#" + id_nama_p).typeahead({
        source: function(query, process) {
            return $.get(
                url,
                {
                    query: query
                },
                function(data) {
                    return process(data);
                }
            );
        },
        displayText: function(item) {
            return item.nama;
        },
        updater: function(item) {
            if (id_hp_p == "" || id_email_p == "") {
            } else {
                $("#" + id_hp_p).val(item.hp_wa);
                $("#" + id_email_p).val(item.email_p);

                if (item.hp_wa == null || item.hp_wa == "") {
                    $("#" + id_hp_p).css("background-color", "white");
                } else {
                    $("#" + id_hp_p).css("background-color", "#b9cae6");
                }

                if (item.email_p == null || item.email_p == "") {
                    $("#" + id_email_p).css("background-color", "white");
                } else {
                    $("#" + id_email_p).css("background-color", "#b9cae6");
                }
            }
            return item;
        }
    });
}
