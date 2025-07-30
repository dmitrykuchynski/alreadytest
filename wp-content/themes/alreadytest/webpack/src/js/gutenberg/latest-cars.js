import '../../styles/gutenberg/latest-cars.scss';
import 'select2';
import IMask from "imask";

document.addEventListener('DOMContentLoaded', () => {
    const blocks = document.querySelectorAll('.alreadymedia-car-search');
    let masks = [];

    if (!blocks.length) return;

    blocks.forEach((block) => {
        const form = jQuery(block).find('form');
        const dynamicInputs = form.find('[data-filter-name]');
        const allInputs = form.find('input, select');

        initSelect(form.find('select[data-filter-name]'));

        const priceMin = block.querySelector('input[data-filter-name="min_price"]');
        const priceMax = block.querySelector('input[data-filter-name="max_price"]');

        if (priceMin && priceMax) {
            masks.push(new IMask(priceMin, getPriceMaskOptions()));
            masks.push(new IMask(priceMax, getPriceMaskOptions()));

            priceMin.addEventListener('change', triggerAjaxUpdate);
            priceMax.addEventListener('change', triggerAjaxUpdate);
        }

        dynamicInputs.on('change', triggerAjaxUpdate);
        dynamicInputs.on('changeDate', triggerAjaxUpdate);

        form.on('reset', function () {
            setTimeout(() => {
                allInputs.val(null).trigger('change');
                masks.forEach(m => m.destroy());
                masks = [];
                updateResults({});
            }, 0);
        });

        form.on('submit', function (e) {
            e.preventDefault();
            triggerAjaxUpdate();
        });

        function triggerAjaxUpdate() {
            let dataForResults = {};

            dynamicInputs.each(function () {
                const $el = jQuery(this);
                const val = $el.val();

                if (val && val.length > 0) {
                    dataForResults[$el.attr('name')] = val;
                }
            });

            updateResults(dataForResults);
        }
    });

    const listOfCars = jQuery('.alreadymedia-list-of-cars');

    listOfCars.on("update-list-of-cars", function (e, ajaxData) {
        const loadingClass = 'alreadymedia-list-of-cars_loading';
        listOfCars.addClass(loadingClass);

        let cardsWrap = listOfCars.find('.alreadymedia-list-of-cars__cards');

        console.log(ajaxData);

        jQuery.ajax({
            url: localizeAlreadymedia.ajax_url,
            type: 'POST',
            data: {
                'action': 'alreadymedia_update_cars_search_results',
                'nonce': localizeAlreadymedia.nonce,
                'filters': ajaxData
            },
            beforeSend: function () {
                cardsWrap.html('');
            },
            success: function (data) {
                if (!data.success) {
                    console.error(data.data);
                }

                if (data.data.html) {
                    cardsWrap.html('');
                    listOfCars.addClass(loadingClass);
                    cardsWrap.append(data.data.html);
                }
            },
            error: function (xhr) {
                console.error(xhr.statusText + xhr.responseText);
            },
            complete: function () {
                listOfCars.removeClass(loadingClass);
            },
        });

    });

    function updateResults(filters) {
        const blocks = jQuery('.alreadymedia-list-of-cars');
        window.alreadymediaCarsSearchFilters = filters;
        blocks.trigger('update-list-of-cars', filters);
    }

    function getPriceMaskOptions() {
        return {
            mask: Number,
            scale: 0,
            thousandsSeparator: ',',
            padFractionalZeros: false,
            normalizeZeros: false,
            radix: '.',
            min: 0,
            max: null,
            autofix: true,
        };
    }

});

export function initSelect(selects, data = []) {
    let Utils = jQuery.fn.select2.amd.require('select2/utils');
    let Dropdown = jQuery.fn.select2.amd.require('select2/dropdown');
    let DropdownSearch = jQuery.fn.select2.amd.require('select2/dropdown/search');
    let CloseOnSelect = jQuery.fn.select2.amd.require('select2/dropdown/closeOnSelect');
    let AttachBody = jQuery.fn.select2.amd.require('select2/dropdown/attachBody');
    let dropdownAdapter = Utils.Decorate(Utils.Decorate(Utils.Decorate(Dropdown, DropdownSearch), CloseOnSelect), AttachBody);

    selects.each((i, item) => {
        let select = jQuery(item);

        let selectData = {
            data: data,
            closeOnSelect: true,
            allowClear: true,
            tags: false,
            dropdownAutoWidth: true,
            minimumResultsForSearch: select.attr('data-search') ? 1 : -1,
            width: '100%',
            placeholder: select.data('placeholder'),
            dropdownParent: select.closest('.alreadymedia-car-search'),
        };

        if (select.attr('data-search')) {
            selectData.dropdownAdapter = dropdownAdapter;
        }

        select.select2(selectData);
    });
}
