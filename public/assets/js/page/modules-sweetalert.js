"use strict";

/*Delete dados SIAF*/

/*Exclusão de plantio*/
$(".delete-plantio").click(function() {
    var id = $(this).data("id");
    var parent = $(this).parent();
    swal({
        title: "Tem certeza?",
        text: "Ao deletar este plantio, a ação não poderá ser desfeita!",
        icon: "warning",
        buttons: {
            cancel: {
                text: "Cancelar",
                visible: true,
                closeModal: true,
            },
            confirm: {
                text: "Deletar",
                closeModal: true
            }
        },
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/painel/plantio/"+id,
                type: 'DELETE', // requisição do tipo delete
                dataType: "JSON",
                data: {
                    "id": id // obtem os dados a serem retornados
                },
                /*Caso não tenha dado nenhum problema na requisição*/
                success: function (data){
                    /*Caso o dado tenha sido deletado com sucesso*/
                    if(data['success']){
                        swal(data['success'], {
                            icon: "success",
                        });
                        /*Remove o elemento da tabela*/
                        parent.slideUp(10, function () {
                            parent.closest("tr").remove();
                        });
                    }else{
                        swal(data['error'], {
                            icon: "error",
                        });
                    }
                },
                /*Caso tenha dado algum problema na requisição*/
                error: function(data) {
                    swal("Não foi possível executar está ação, tente novamente!", {
                        icon: "error",
                    });
                }
            });
        }
    });
});

/*Exclusão de talhao*/
$(".delete-talhao").click(function() {
    var id = $(this).data("id");
    var parent = $(this).parent();
    swal({
        title: "Tem certeza?",
        text: "Ao deletar este talhão, a ação não poderá ser desfeita!",
        icon: "warning",
        buttons: {
            cancel: {
                text: "Cancelar",
                visible: true,
                closeModal: true,
            },
            confirm: {
                text: "Deletar",
                closeModal: true
            }
        },
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/painel/talhao/"+id,
                type: 'DELETE', // requisição do tipo delete
                dataType: "JSON",
                data: {
                    "id": id // obtem os dados a serem retornados
                },
                /*Caso não tenha dado nenhum problema na requisição*/
                success: function (data){
                    /*Caso o dado tenha sido deletado com sucesso*/
                    if(data['success']){
                        swal(data['success'], {
                            icon: "success",
                        });
                        /*Remove o elemento da tabela*/
                        parent.slideUp(10, function () {
                            parent.closest("tr").remove();
                        });
                    }else{
                        swal(data['error'], {
                            icon: "error",
                        });
                    }
                },
                /*Caso tenha dado algum problema na requisição*/
                error: function(data) {
                    swal("Não foi possível executar está ação, tente novamente!", {
                        icon: "error",
                    });
                }
            });
        }
    });
});

/*Exclusão de talhao*/
$(".delete-manejo").click(function() {
    var id = $(this).data("id");
    var parent = $(this).parent();
    swal({
        title: "Tem certeza?",
        text: "Ao deletar este manejo, a ação não poderá ser desfeita!",
        icon: "warning",
        buttons: {
            cancel: {
                text: "Cancelar",
                visible: true,
                closeModal: true,
            },
            confirm: {
                text: "Deletar",
                closeModal: true
            }
        },
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/painel/manejo/"+id,
                type: 'DELETE', // requisição do tipo delete
                dataType: "JSON",
                data: {
                    "id": id // obtem os dados a serem retornados
                },
                /*Caso não tenha dado nenhum problema na requisição*/
                success: function (data){
                    /*Caso o dado tenha sido deletado com sucesso*/
                    if(data['success']){
                        swal(data['success'], {
                            icon: "success",
                        });
                        /*Remove o elemento da tabela*/
                        parent.slideUp(10, function () {
                            parent.closest("tr").remove();
                        });
                    }else{
                        swal(data['error'], {
                            icon: "error",
                        });
                    }
                },
                /*Caso tenha dado algum problema na requisição*/
                error: function(data) {
                    swal("Não foi possível executar está ação, tente novamente!", {
                        icon: "error",
                    });
                }
            });
        }
    });
});