import '../../styles/gutenberg/latest-cars.scss';
import 'select2';
import IMask from 'imask';

document.addEventListener('DOMContentLoaded', () => {
    const blocks = document.querySelectorAll('.alreadymedia-car-search');

    if (!blocks.length) return;

    blocks.forEach((block) => {
        const form = jQuery(block).find('form');
        const dynamicInputs = form.find('[data-filter-name]');
        const allInputs = form.find('input, select');

        initSelect(form.find('select[data-filter-name]'));

        const priceMin = block.querySelector('input[data-filter-name="min_price"]');
        const priceMax = block.querySelector('input[data-filter-name="max_price"]');
        let masks = [];

        if (priceMin && priceMax) {
            masks.push(new IMask(priceMin, getPriceMaskOptions()));
            masks.push(new IMask(priceMax, getPriceMaskOptions()));

            priceMin.addEventListener('change', triggerPriceUpdate);
            priceMax.addEventListener('change', triggerPriceUpdate);
        }

        // Handle filter changes
        // dynamicInputs.on('change', triggerAjaxUpdate);

        // Load dynamic min/max prices and update masks
        jQuery.ajax({
            url: localizeAlreadymedia.ajax_url,
            type: 'POST',
            data: {
                action: 'alreadymedia_update_cars_search_results',
                nonce: localizeAlreadymedia.nonce,
                get_price_range: true
            },
            success: function (response) {
                if (!response.success || !response.data) return;
                updatePriceMasks(response.data.min_price, response.data.max_price);
            }
        });

        // Reset form and filters
        form.on('reset', function () {
            setTimeout(() => {
                location.reload();
            }, 0);
        });

        // Intercept form submission
        form.on('submit', function (e) {
            e.preventDefault();
            triggerAjaxUpdate();
        });

        function triggerAjaxUpdate() {
            const dataForResults = {};

            dynamicInputs.each(function () {
                const $el = jQuery(this);
                const val = $el.val();

                if (val && val.length > 0) {
                    dataForResults[$el.attr('name')] = val;
                }
            });

            updateResults(dataForResults);
        }

        function triggerPriceUpdate() {
            const dataForResults = {};

            dynamicInputs.each(function () {
                const $el = jQuery(this);
                const val = $el.val();

                if (val && val.length > 0) {
                    dataForResults[$el.attr('name')] = val;
                }
            });
        }

        function updatePriceMasks(minData, maxData) {
            if (!(priceMin && priceMax)) return;

            masks.forEach(m => m.destroy());
            masks = [];

            if (minData.placeholder) {
                priceMin.setAttribute('placeholder', minData.placeholder);
            }

            if (maxData.placeholder) {
                priceMax.setAttribute('placeholder', maxData.placeholder);
            }

            if (minData.min) {
                priceMin.setAttribute('data-min', minData.min);
            }

            if (maxData.max) {
                priceMax.setAttribute('data-max', maxData.max);
            }

            const min = Number.isFinite(parseFloat(minData.min)) ? parseFloat(minData.min) : 0;
            const max = Number.isFinite(parseFloat(maxData.max)) ? parseFloat(maxData.max) : null;

            // Apply proper min/max ranges for both fields
            masks.push(new IMask(priceMin, {
                ...getPriceMaskOptions(),
                min,
                max
            }));

            masks.push(new IMask(priceMax, {
                ...getPriceMaskOptions(),
                min,
                max
            }));
        }
    });

    const listOfCars = jQuery('.alreadymedia-list-of-cars');

    listOfCars.on('update-list-of-cars', function (e, ajaxData) {
        const loadingClass = 'alreadymedia-list-of-cars_loading';
        const cardsWrap = listOfCars.find('.alreadymedia-list-of-cars__cards');

        listOfCars.addClass(loadingClass);

        jQuery.ajax({
            url: localizeAlreadymedia.ajax_url,
            type: 'POST',
            data: {
                action: 'alreadymedia_update_cars_search_results',
                nonce: localizeAlreadymedia.nonce,
                filters: ajaxData
            },
            beforeSend: function () {
                cardsWrap.html('');
            },
            success: function (data) {
                if (!data.success) {
                    console.error(data.data);
                    return;
                }

                if (data.data.html) {
                    cardsWrap.html(data.data.html);
                }
            },
            error: function (xhr) {
                console.error(`${xhr.statusText}: ${xhr.responseText}`);
            },
            complete: function () {
                listOfCars.removeClass(loadingClass);
            },
        });
    });

    function updateResults(filters) {
        const resultBlocks = jQuery('.alreadymedia-list-of-cars');
        window.alreadymediaCarsSearchFilters = filters;
        resultBlocks.trigger('update-list-of-cars', filters);
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
            autofix: true
        };
    }
});

export function initSelect(selects, data = []) {
    if (!jQuery.fn.select2) {
        console.warn('Select2 is not loaded.');
        return;
    }

    const Utils = jQuery.fn.select2.amd.require('select2/utils');
    const Dropdown = jQuery.fn.select2.amd.require('select2/dropdown');
    const DropdownSearch = jQuery.fn.select2.amd.require('select2/dropdown/search');
    const CloseOnSelect = jQuery.fn.select2.amd.require('select2/dropdown/closeOnSelect');
    const AttachBody = jQuery.fn.select2.amd.require('select2/dropdown/attachBody');

    const dropdownAdapter = Utils.Decorate(
        Utils.Decorate(
            Utils.Decorate(Dropdown, DropdownSearch),
            CloseOnSelect
        ),
        AttachBody
    );

    selects.each((i, item) => {
        const select = jQuery(item);
        const hasSearch = !!select.attr('data-search');

        const selectData = {
            data,
            closeOnSelect: true,
            allowClear: true,
            tags: false,
            dropdownAutoWidth: true,
            minimumResultsForSearch: hasSearch ? 1 : -1,
            width: '100%',
            placeholder: select.data('placeholder'),
            dropdownParent: select.closest('.alreadymedia-car-search'),
            ...(hasSearch && { dropdownAdapter })
        };

        select.select2(selectData);
    });
}
