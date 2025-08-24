"use strict";

var KTDynamicTable = function () {
    var table, $searchInput, $filters, $tableEl;

    // حذف صف واحد
    const handleDeleteRow = () => {
        $tableEl.querySelectorAll('[data-kt-table-filter="delete_row"]').forEach((btn) => {
            btn.addEventListener("click", function (e) {
                e.preventDefault();
                const tr = e.target.closest("tr");
                const name = tr.querySelectorAll("td")[1]?.innerText || "this item";

                Swal.fire({
                    text: "Are you sure you want to delete " + name + "?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        table.row($(tr)).remove().draw();
                        Swal.fire({
                            text: "You have deleted " + name + "!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {confirmButton: "btn fw-bold btn-primary"}
                        });
                    }
                });
            });
        });
    };

    // حذف متعدد
    const handleDeleteSelected = () => {
        const checkboxes = $tableEl.querySelectorAll('tbody [type="checkbox"]');
        const deleteSelectedBtn = document.querySelector('[data-kt-table-select="delete_selected"]');

        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener("click", () => {
                setTimeout(updateToolbar, 50);
            });
        });

        if (deleteSelectedBtn) {
            deleteSelectedBtn.addEventListener("click", () => {
                Swal.fire({
                    text: "Are you sure you want to delete selected items?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        checkboxes.forEach((cb) => {
                            if (cb.checked) {
                                const tr = cb.closest("tr");
                                table.row($(tr)).remove().draw();
                            }
                        });
                        updateToolbar();
                        Swal.fire({
                            text: "Deleted all selected items!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {confirmButton: "btn fw-bold btn-primary"}
                        });
                    }
                });
            });
        }
    };

    // تحديث شريط الأدوات عند تحديد صفوف
    const updateToolbar = () => {
        const toolbarBase = document.querySelector('[data-kt-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-table-toolbar="selected"]');
        const selectedCountEl = document.querySelector('[data-kt-table-select="selected_count"]');
        const checkboxes = $tableEl.querySelectorAll('tbody [type="checkbox"]');

        let selected = 0;
        checkboxes.forEach(cb => cb.checked && selected++);

        if (selected > 0) {
            toolbarBase?.classList.add("d-none");
            toolbarSelected?.classList.remove("d-none");
            selectedCountEl && (selectedCountEl.innerHTML = selected);
        } else {
            toolbarBase?.classList.remove("d-none");
            toolbarSelected?.classList.add("d-none");
        }
    };

    // تهيئة DataTable
    const initTable = () => {
        if (!$tableEl) return;

        table = $($tableEl).DataTable({
            info: false,
            order: [],
            columnDefs: [
                { orderable: false, targets: 0 }, // افتراضي العمود الأول غير قابل للترتيب
                { orderable: false, targets: -1 } // آخر عمود عادةً للخيارات
            ]
        });

        table.on("draw", () => {
            updateToolbar();
            handleDeleteRow();
        });
    };

    // البحث
    const initSearch = () => {
        if ($searchInput) {
            $searchInput.addEventListener("keyup", function (e) {
                table.search(e.target.value).draw();
            });
        }
    };

    // الفلاتر الديناميكية
    const initFilters = () => {
        if (!$filters) return;

        $filters.forEach(filter => {
            const applyBtn = filter.querySelector('[data-kt-table-filter="filter"]');
            const resetBtn = filter.querySelector('[data-kt-table-filter="reset"]');

            applyBtn?.addEventListener("click", () => {
                const values = [];
                filter.querySelectorAll('input:checked').forEach(input => values.push(input.value));
                table.search(values.join(" ")).draw();
            });

            resetBtn?.addEventListener("click", () => {
                filter.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(i => i.checked = i.defaultChecked);
                table.search("").draw();
            });
        });
    };

    return {
        init: function (tableSelector, searchSelector = null, filtersSelector = null) {
            $tableEl = document.querySelector(tableSelector);
            $searchInput = document.querySelector(searchSelector);
            $filters = document.querySelectorAll(filtersSelector);

            initTable();
            handleDeleteRow();
            handleDeleteSelected();
            initSearch();
            initFilters();
        }
    };
}();

// مثال الاستخدام
KTUtil.onDOMContentLoaded(function () {
    KTDynamicTable.init(
        "#kt_customers_table",
        '[data-kt-customer-table-filter="search"]',
        '.kt-table-filter-container' // ضع هذا على div يحتوي كل الفلاتر
    );
});
