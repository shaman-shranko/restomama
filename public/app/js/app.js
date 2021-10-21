$(document).ready(function(){
    initSearchForm();
    initMaterializeComponents();
    initProductCalendar();

    $('.collapsible').collapsible();
    $('.sidenav').sidenav();
    $('select').formSelect();
    $('.tabs').tabs();
});
$(window).on('load', function(){
    initBanner();
});

/**
 * Function for initializing sliders
 */
function initBanner(){
    var productSliders = $('.productSlider');
    if(productSliders !== undefined){
        productSliders.slick({
            dots: true,
            prevArrow: '<button class="prev-arrow"><i class="material-icons">keyboard_arrow_left</i></button>',
            nextArrow: '<button class="next-arrow"><i class="material-icons">keyboard_arrow_right</i></button>',
            infinite: false,
        });
    }
    var menuSliders = $('.menuSlider');
    if(menuSliders !== undefined){
        menuSliders.slick({
            dots: true,
            prevArrow: '<button class="prev-arrow"><i class="material-icons">keyboard_arrow_left</i></button>',
            nextArrow: '<button class="next-arrow"><i class="material-icons">keyboard_arrow_right</i></button>',
            infinite: false,
        });
    }
}
function initMaterializeComponents() {
    $('.dropdown-trigger').dropdown();
    $('.sidenav').sidenav({
        draggable: true,
    });
    $('.collapsible').collapsible();
}
function initSearchForm(){
    var date = new Date();
    $('.datepicker').datepicker({
        firstDay: 1,
        minDate: date,
        format: 'yyyy-mm-dd',
        i18n: {
            cancel: 'Отмена',
            clear: 'Очистить',
            months: [
                'Январь',
                'Февраль',
                'Март',
                'Апрель',
                'Май',
                'Июнь',
                'Июль',
                'Август',
                'Сентябрь',
                'Октябрь',
                'Ноябрь',
                'Декабрь'
            ],
            monthsShort: [
                'Янв',
                'Фев',
                'Мар',
                'Апр',
                'Май',
                'Июн',
                'Июл',
                'Авг',
                'Сен',
                'Окт',
                'Ноя',
                'Дек'
            ],
            weekdays: [
                'Воскресенье',
                'Понедельник',
                'Вторник',
                'Среда',
                'Четверг',
                'Пятница',
                'Суббота'
            ],
            weekdaysShort: [
                'Вc',
                'Пн',
                'Вт',
                'Ср',
                'Чт',
                'Пт',
                'Сб'
            ],
            weekdaysAbbrev: [
                'Вc',
                'Пн',
                'Вт',
                'Ср',
                'Чт',
                'Пт',
                'Сб'
            ],
        }
    });

    $('select').formSelect();
    // Change 'form' to class or ID of your specific form
    $("form").submit(function() {
        $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
        return true; // ensure form still submits
    });

    // Un-disable form fields when page loads, in case they click back after submission
    $( "form" ).find( ":input" ).prop( "disabled", false );
}
function initProductCalendar(){

}
