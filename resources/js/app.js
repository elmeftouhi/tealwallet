/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.moment = require('moment');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

function doSearch() {
    var q = document.getElementById("q");
    var v = q.value.toLowerCase();
    var rows = document.getElementsByTagName("tr");
    var on = 0;
    for ( var i = 0; i < rows.length; i++ ) {
        var fullname = rows[i].getElementsByTagName("td");
        fullname = fullname[0].innerHTML.toLowerCase();
        if ( fullname ) {
            if ( v.length == 0 || (v.length < 3 && fullname.indexOf(v) == 0) || (v.length >= 3 && fullname.indexOf(v) > -1 ) ) {
            rows[i].style.display = "";
            on++;
        } else {
            rows[i].style.display = "none";
        }
        }
    }
    var n = document.getElementById("noresults");
    if ( on == 0 && n ) {
        n.style.display = "";
        document.getElementById("qt").innerHTML = q.value;
    } else {
        n.style.display = "none";
    }
}

$(window).on('load', function() {
    /** Get Avg */
    if($(".avg_day").length>0 && $(".avg_month").length>0 ){
        $.ajax({
            type        :     "GET",
            url         :      "/expense/graph/avg",
            dataType    :     "json",
        }).done(function(response){
            $(".avg_day").html(response.day);
            $(".avg_month").html(response.month);
        }).fail(function(xhr, textStatus, error) {
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
        });
    } 
    if($(".autofocus").length){
        $(".autofocus").focus();  
    }
});


function toggleFullScreen() {
    if (!document.fullscreenElement &&    // alternative standard method
        !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {  // current working methods
        if (document.documentElement.requestFullscreen) {
        document.documentElement.requestFullscreen();
        } else if (document.documentElement.msRequestFullscreen) {
        document.documentElement.msRequestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
        document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
        document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.exitFullscreen) {
        document.exitFullscreen();
        } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
        } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
        }
    }
}

function money(amount){
    return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'Mad' }).format(amount);
}

$(document).ready(function(){


    /** Show Full Screen */
    $('.show_full_screen').on('click', function(e){
        e.preventDefault();
        toggleFullScreen();
        $(this).find('i').toggleClass('hide');
    });

    /** Display Selected Icon */
    $("select#icon").on('change', function(){
        $('.icon_display').html( $("select#icon option:selected").attr("data-icon") );
    })

    /** Show Upload File */
    $(".show-upload").on("click", function(){
        var target = $(this).attr('data-target');
        if($('#'+target).length > 0){
            $('#'+target).trigger('click');
        }
    })

    $('#avatar').on('change', function(){
        if($(this).val() != ""){
            if($('#'+$(this).attr('data-target')).length > 0){
                $('#'+$(this).attr('data-target')).submit();
            }
        }
    });

    /*****  TABLE SEARCH */
    $(".input_search").on("input", function(){
        
        var target = $(this).attr("data-target");
        var r = $(this).val().toLowerCase();
        var total = 0;
        $("table."+target+" tbody tr").each(function(){
            var isExists = false;
            var tr = $(this);
            $(this).find('td').each(function(){
                var compare = $(this).text().toLowerCase();
                if(compare.length != 0){
                    if(compare.indexOf(r) >= 0){
                        isExists = true
                    }
                }
            });
            if( !isExists ) {
                tr.addClass('hidden');
            }else{
                tr.removeClass('hidden');
                total = parseInt(tr.attr('data-amount'))+parseInt(total);
                $(".total_amount").html(money(total));
            }
        });
    });

    /*****  Close Session Message */
    $(".alert-close").on("click", function(){
        $("." + $(this).attr("data-target") ).remove();
    });

    /*****  Show Alerts */
    $(".notifications").on("click", function(e){
        if(e.target != this) return;
        $(".notifications").addClass('hide');
    });

    $(".notifications_show").on("click", function(){
        var _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url         :   '/alerts',
            method      :   'POST',
            data        :   {'_token': _token},
            dataType    :   'json',
            success     :   function(r){
                $.each(r, function(index, element) {
                    console.log(element.alert_message);
                });
                
            }
        });
        $(".notifications").removeClass('hide');
    });

    $('.show_sidenav').on('click', function(){
        if($('#sidenav').hasClass('hide')){
            $('#sidenav').toggleClass('hide');
            $('#sidenav nav').toggleClass('-ml-64', 300);
        }else{
            $('#sidenav nav').toggleClass('-ml-64', 300);
            $('#sidenav').toggleClass('hide',300);
            
        }

    });
    
    $('#sidenav').on('click', function(e){
        if(e.target != this) return;
        $('#sidenav nav').toggleClass('-ml-64', 400);
        $('#sidenav').toggleClass('hide',400);
        
    });

    /** Chart Js */
    $(".chart_periode").on('change', function(){
        $(".chart_change").attr("data-value",0 );
        var thisYear = moment().format('YYYY');
        var thisMonth = moment().format('MM');
        var url = $(this).val() === "month"? "/expense/graph/"+thisYear+"/"+thisMonth: "/expense/graph/"+thisYear;
        var that = $(this);

        var total = 0;
        $('.lds-ripple').parent().removeClass('hide');
        $.ajax({
            type        :     "GET",
            url         :      url,
            dataType    :     "json",
        }).done(function(response){
            var labels = [];
            var values = [];
            var total = 0;
            for (var key in response){
                labels.push(key);
                values.push(response[key]);
                total = parseInt(total) + parseInt(response[key]);
            }
            total = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'Mad' }).format(total);
            $('.lds-ripple').parent().addClass('hide');
            myChart.data.labels=labels;
            myChart.data.datasets[0].data=values;
            myChart.data.datasets[0].label = that.val() === "month"? 'Expense Of ' + thisMonth + '-' + thisYear + ' Total : ' + total: 'Expense Of ' + thisYear + ' Total : ' + total;
            myChart.update();

            config.labels = labels;
            config.data = values;
            config.caption = that.val() === "month"? 'Expense Of ' + thisMonth + '-' + thisYear + ' Total : ' + total: 'Expense Of ' + thisYear + ' Total : ' + total;
    
        }).fail(function(xhr) {
            $("#preloader").remove();
            alert("Error");
            console.log(xhr.responseText);
        });
    })
    
    $(".chart_change").on('click', function(){

        var direction = $(this).attr("data-direction");
        var current = parseInt( $(this).attr("data-value") );
        var nextValue = direction==='next'? current+1: current-1;
        var chart_periode = $(".chart_periode").val();
        var nextYear = moment().add(nextValue, chart_periode).format('YYYY');
        var nextMonth = moment().add(nextValue, chart_periode).format('MM');

        $(".chart_change").attr("data-value", nextValue);
        $('.lds-ripple').parent().removeClass('hide');

        var url = chart_periode === "month"? "/expense/graph/"+nextYear+"/"+nextMonth: "/expense/graph/"+nextYear;

        $.ajax({
            type        :     "GET",
            url         :      url,
            dataType    :     "json",
        }).done(function(response){
            var labels = [];
            var values = [];
            var total = 0;
            for (var key in response){
                labels.push(key);
                values.push(response[key]);
                total = parseInt(total) + parseInt(response[key]);
            }
            total = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'Mad' }).format(total);
            $('.lds-ripple').parent().addClass('hide');
            
            config.labels = labels;
            config.data = values;
            config.caption = chart_periode === "month"? 'Expense Of ' + nextMonth + '-' + nextYear + ' Total : ' + total: 'Expense Of ' + nextYear+ ' Total : ' + total;

            myChart.data.labels=config.labels;
            myChart.data.datasets[0].data=config.data;
            myChart.data.datasets[0].label = config.caption;

            myChart.update();
    
        }).fail(function(xhr) {
            $("#preloader").remove();
            alert("Error");
            console.log(xhr.responseText);
        });


    });

    $(".chart_type").on('change', function(){
        config.type = $(this).val();

        myChart.destroy();
        myChart = new Chart(ctx, {
          type: config.type,
          data: {
              labels: config.labels,
              datasets: [{
                  label: config.caption,
                  data: config.data,
                  borderWidth: 1,
                  borderColor: "rgba(35, 78, 82, 0.7)",
                  backgroundColor: "rgba(35, 78, 82, 0.5)"
              }]
          },
          options: {
            tooltips:{
                enabled: true,
                mode: 'single',
                callbacks: {
                    label: function(tooltipItems, data) { 
                        return 'Total Expense : ' + new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'Mad' }).format(tooltipItems.yLabel);
                    }
                }
            },
              scales: {
                  yAxes: [{
                      ticks: {
                            beginAtZero: false,
                            stepSize:100,
                            min:0
                      }
                  }],
                  xAxes: [{
                      ticks: {
                          beginAtZero: false,
                          fontSize: 8
                      }
                  }]
              }
          }

        });

    });


    //$("table tbody").sortable();
    var $categories = $('table tbody');
    $categories.sortable({
        cancel: 'thead',
        stop: () => {
           var items = $categories.sortable('toArray', {attribute: 'data-id'});
           var _token = $('meta[name="csrf-token"]').attr('content');
           $.post(
                '/category/reorder',
                {'_token':_token, 'categories':items},
                function(r){
                    location.reload();
                }
           ).fail(function(r){
               alert('Request failled');
               console.log(r);
           });
        }
    });


    $('#category_destory_btn').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        $('form#category_destroy').submit();
    });

    $('#expense_destory_btn').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        $('form#expense_destroy').submit();
    });


    /** Get Sums */
    if($(".expense_graph_sums").length){
        $.ajax({
            type        :     "GET",
            url         :      "/expense/graph/sums",
            dataType    :     "json",
        }).done(function(response){
            $(".sum_today").html(response.today);
            $(".sum_week").html(response.week);
            $(".sum_month").html(response.month);
            $(".sum_year").html(response.year);
        }).fail(function(xhr, textStatus, error) {
            $("#preloader").remove();
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
        });
    }
});

const app = new Vue({
    el: '#app',
});


import Chart from 'chart.js';
import { timers } from 'jquery';
import { split } from 'lodash';
var config = {
    type : 'line',
    caption :   '',
    labels : [],
    data : [],
    colors:[]
};

if($("#myChart").length){
    $('#myChart .lds-ripple').parent().removeClass('hide');
    var ctx = document.getElementById('myChart');
    var thisYear = moment().format('YYYY');
    var thisMonth = moment().format('MM');
    var myChart = new Chart(ctx, {
        type: config.type,
        data: {
            labels: [],
            datasets: [{
                label: 'Expense Of ' + thisMonth,
                data: [],
                borderWidth: 1,
                showLine:true,
                borderColor: "rgba(35, 78, 82, 0.7)",
                backgroundColor: "rgba(35, 78, 82, 0.5)"
            }]
        },
        options: {
            tooltips:{
                enabled: true,
                mode: 'single',
                callbacks: {
                    label: function(tooltipItems, data) { 
                        return 'Total Expense : ' + new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'Mad' }).format(tooltipItems.yLabel);
                    }
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false,
                        stepSize:100,
                        min:0
                    }
                }],
                xAxes: [{
                    ticks: {
                        beginAtZero: false,
                        fontSize: 8
                    }
                }]
            }
        }
    });


    $.ajax({
        type        :     "GET",
        url         :      "/expense/graph/"+thisYear+"/"+thisMonth,
        dataType    :     "json",
    }).done(function(response){
        var labels = [];
        var values = [];
        var total = 0;
        for (var key in response){
            labels.push(key);
            values.push(response[key]);
            total = parseInt(total) + parseInt(response[key]);
        }
        total = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'Mad' }).format(total);
        config.labels = labels;
        config.data = values;
        config.caption = 'Expense Of ' + thisMonth + '-' + thisYear + ' Total : ' + total;
        $('#myChart .lds-ripple').parent().addClass('hide');
        //console.log(response);

        myChart.data.labels=config.labels;
        myChart.data.datasets[0].data=config.data;
        myChart.data.datasets[0].label = config.caption,
        myChart.update();

    }).fail(function(xhr, textStatus, error) {
        $("#preloader").remove();
        console.log(xhr.statusText);
        console.log(textStatus);
        console.log(error);
    });
}

if($("#myPieChart").length){
    var splited = split($(".dates_current").html(), ' - ');
    $('.lds-ripple').parent().removeClass('hide');
    var ctx = document.getElementById('myPieChart');
    var thisYear = splited[1]; // moment().format('YYYY');
    var thisMonth = splited[0]; // moment().format('MM');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [],
            datasets: [{
                label: 'Expense Of ' + thisMonth,
                data: []
            }]
        },
        options:{
            legend:{
                position: 'bottom',
                align : 'start',
                display:true,
                labels:{
                    boxWidth : 10,
                    fontSize: 10
                }
            }
        }
    });


    $.ajax({
        type        :     "GET",
        url         :      "/expense/pie/"+thisYear+"/"+thisMonth,
        dataType    :     "json",
    }).done(function(response){
        var labels = [];
        var values = [];
        var total = 0;
        var colors = [];
        var splited;
        for (var key in response){
            splited = split(key, "|");
            labels.push(splited[0]);
            colors.push(splited[1]);
            values.push(response[key]);
            total = parseInt(total) + parseInt(response[key]);
        }
        total = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'Mad' }).format(total);
        config.labels = labels;
        config.data = values;
        config.colors = colors;
        config.caption = 'Expense Of ' + thisMonth + '-' + thisYear + ' Total : ' + total;
        $('.lds-ripple').parent().addClass('hide');
        myPieChart.data.labels=config.labels;
        myPieChart.data.datasets[0].data=config.data;
        myPieChart.data.datasets[0].backgroundColor=colors;
        myPieChart.data.datasets[0].label = config.caption,
        myPieChart.update();

    }).fail(function(xhr, textStatus, error) {
        $("#preloader").remove();
        console.log(xhr.statusText);
        console.log(textStatus);
        console.log(error);
    });
}
