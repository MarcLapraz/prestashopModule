
    $(document).ready(function () {
        $(".va").on('click', function (event) {

            var carte = $('#id_category').val();
            var point = $('#nbpoints').val();

            if (carte === "") {
                alert("Merci de renseigner le numero de carte");
                event.preventDefault();
            }

            $('#info').text('');
		
            var d = new Date();
            var n = d.getTime();
            $.ajax({
                url: '../modules/smoke/ajax.php',
                data:
                        {
                            action: 'get_products',
                            token: n,
                            id_category: carte,
                            nbpoints: point
                        },
                method: 'POST',
                success: function (data) {

                    $('#info').removeClass('hidden');
                    $('#cumul').removeClass('hidden');
                    if (data == "false") {
                        $('#info').append("Cette carte n est pas valide");
                    } else {
                        $object = JSON.parse(data);

                        if ($object.totalpoint == null) {

                            $object.totalpoint = 0;
                            $object.stat = "Aucun status";
                        }

                        if (point != '') {
                            $('#resultdata').removeClass('hidden');
                            $('#info').append("Voulez-vous créditer la carte ID " + $('#id_category').val() + ' de ' + $object.genre + ".  " + $object.nom + "   " + $object.prenom + " de " + $('#nbpoints').val() + " points?  " + $object.totalpoint + " ( " + $object.stat + " ) ");
                            $('#saise').addClass('hidden');
                        } else {

                            $("#info").append("Accès compte client");
                        }

                        var numero = $object.numero;
                        var idCustom = $('#id_customer').val(numero);

                        $("#ficheClient").removeClass('hidden');
                        var link = 'https://xxxxx.ch/Backoffice/index.php?controller=AdminCustomers&id_customer=' + numero + '&viewcustomer&token=XXXXXX';
                        $("#link").attr("href", link);



                    }
                },
                fail: function () {
                    alert("erreur de réseau...");
                }

            });
            //}
        });

    });



    $(document).ready(function () {
        $(".va").on('click', function (event) {

            var carte = $('#id_category').val();
            var point = $('#nbpoints').val();

            if (carte === "") {
                alert("Merci de renseigner le numero de carte");
                event.preventDefault();

            }


            $('#info').text('');

            var d = new Date();
            var n = d.getTime();
            $.ajax({
                url: '../modules/smoke/ajax.php',
                data:
                        {
                            action: 'get_cumul',
                            token: n,
                            id_category: carte,
                            nbpoints: point
                        },
                method: 'POST',
                success: function (data) {

                    $object = JSON.parse(data);
                    $("#cumul").append("Cumulation totale des points :   " + $object.cumulpoints);


                },
                fail: function () {
                    alert("erreur de réseau...");
                }

            });
            //}
        });

    });

    $(document).ready(function () {

        $('#btnConf').on('click', function () {
            var d = new Date();
            var n = d.getTime();
            $.ajax({
                url: '../modules/smoke/ajax.php',
                data:
                        {
                            action: 'insertpoints',
                            token: n,
                            id_customer: $('#id_customer').val(),
                            nbpoints: $('#nbpoints').val()
                        },
                method: 'POST',
                success: function (data) {

                    $('#resultdata').addClass('hidden');
                    $('#id_category').val('');
                    $('#nbpoints').val('');
                    $('#id_customer').val('');
                    $('#saise').removeClass('hidden');
                    $("#info").empty();


                },
                fail: function () {
                    alert("erreur de réseau...");
                }
            });
        });
    });

    $(document).ready(function () {

        $('#annuletrans').on('click', function () {

            $('#resultdata').addClass('hidden');
            $('#id_category').val('');
            $('#nbpoints').val('');
            $('#id_customer').val('');
            $("#info").empty();
            $('#info').addClass('hidden');
            $("#cumul").empty();
            $('#cumul').addClass('hidden');
            $('#saise').removeClass('hidden');

        });
    });

    $(document).ready(function () {

        $('#annuleselect').on('click', function () {

            $('#resultdata').addClass('hidden');
            $('#id_category').val('');
            $('#nbpoints').val('');
            $('#id_customer').val('');
            $('#id_customer').val('');
            $('#saise').removeClass('hidden');
            $('#info').addClass('hidden');
            $("#info").empty();
            $('#cumul').addClass('hidden');
            $("#cumul").empty()

        });
    });
