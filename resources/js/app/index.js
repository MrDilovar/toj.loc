$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function() {
    'use strict';
    let forms = $('.formsValidate');
    [].filter.call(forms, function(form) {
        $(form).submit(function(event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }

            $(form).addClass('was-validated');
        });
    });
});

$(function () {
    if(!$('.hmenu').length) return;

    var hamburger = $('.hamburger-hmenu'),
        innerMain = $('.inner-main'),
        hmenuBackground = $('.hmenu-background'),
        menu = $('.hmenu'),
        body = $(document.body),
        isActive = false;

    hamburger.on('click', function() {
        innerMain.toggleClass('active');
        menu.toggleClass('active');
        body.addClass('stop-scrolling');
        isActive = true;
    });

    hmenuBackground.on('click', function() {
        if(isActive) {
            innerMain.toggleClass('active');
            menu.toggleClass('active');
            body.removeClass('stop-scrolling');
            isActive = false;
        }
    });

    $('.hmenu-catalog .next-item').click(function(e) {
        let self = $(this);

        $(".hmenu-catalog-nav[data-menu-id=" + self.data().menuId + "]").hide();
        $(".hmenu-catalog-nav[data-menu-id=" + self.data().nextMenuId + "]").show();

        e.preventDefault();
    });

    $('.hmenu-catalog .prev-item').click(function(e) {
        let self = $(this);

        $(".hmenu-catalog-nav[data-menu-id=" + self.data().menuId + "]").hide();
        $(".hmenu-catalog-nav[data-menu-id=" + self.data().prevMenuId + "]").show();

        e.preventDefault();
    });
});

$(function () {
    if (!$('.c-filter-widget .filter-title').length) return;

    $('.c-filter-widget .filter-title').click(function (e) {
        let filter = $(this.parentElement),
            selectorsBlock = $('.hide-block', filter),
            angle = $('.angle', filter);

        if (selectorsBlock.hasClass('hide')) {
            selectorsBlock.removeClass('hide').addClass('show').show();
            angle.removeClass('ti-angle-right').addClass('ti-angle-down');
        } else {
            selectorsBlock.removeClass('show').addClass('hide').hide();
            angle.removeClass('ti-angle-down').addClass('ti-angle-right');
        }
    });
});


// var Tojir = {
//     attributeFilters: [],
//     setFilters: function(filter_id, filter_value_id) {
//         let attributeFilters = this.attributeFilters,
//             filter = attributeFilters.find(function (item) {
//                 return item.filter_id === filter_id;
//             });
//
//         if (filter) {
//             let valuePos = filter.filter_values_id.indexOf(filter_value_id);
//
//             if (valuePos >= 0) {
//                 filter.filter_values_id.splice(valuePos, 1);
//                 if (filter.filter_values_id.length === 0) {
//                     let filterPos = attributeFilters.findIndex(function (item) {
//                         return item.filter_id === filter_id;
//                     });
//
//                     attributeFilters.splice(filterPos, 1);
//                 }
//             } else
//                 filter.filter_values_id.push(filter_value_id);
//         } else {
//             attributeFilters.push({
//                 filter_id,
//                 filter_values_id: [filter_value_id]
//             });
//         }
//     },
// };
//
// $(function() {
//     $('.filterCheckbox').click(function (e) {
//         let filter_id = this.dataset.filter,
//             filter_value_id = this.dataset.filtervalue;
//
//         Tojir.setFilters(filter_id, filter_value_id);
//         // console.log(Tojir.filter.filters);
//     });
// });
