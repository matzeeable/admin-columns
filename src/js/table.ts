import Table, {TableEventPayload} from "./table/table";
import Tooltip from "./modules/tooltips";
import ScreenOptionsColumns from "./table/screen-options-columns";
import ToggleBoxLink from "./modules/toggle-box-link";
// @ts-ignore
import $ from 'jquery';
import {auto_init_show_more} from "./plugin/show-more";
import {init_actions_tooltips} from "./table/functions";
import {EventConstants} from "./constants";
import {getIdFromTableRow, resolveTableBySelector} from "./helpers/table";
import {initAcServices} from "./helpers/admin-columns";
import Modals from "./modules/modals";
import {initPointers} from "./modules/ac-pointer";
import {LocalizedAcTable} from "./types/table";

declare let AC: LocalizedAcTable

let AC_SERVICES = initAcServices();

AC_SERVICES.registerService('Modals', new Modals());

document.addEventListener('DOMContentLoaded', () => {
    let table = resolveTableBySelector(AC.table_id);

    initPointers();

    if (table) {
        const TableModule = new Table(table, AC_SERVICES).init();
        AC_SERVICES.registerService('Table', TableModule);
        AC_SERVICES.registerService('ScreenOptionsColumns', new ScreenOptionsColumns(TableModule.Columns));
    }

    AC_SERVICES.registerService('Tooltips', new Tooltip());

    document.querySelectorAll<HTMLLinkElement>('.ac-toggle-box-link').forEach(el => {
        new ToggleBoxLink(el);
    });

    $('.wp-list-table').on('updated', 'tr', function () {
        AC_SERVICES.getService<Table>('Table').addCellClasses();
        auto_init_show_more();
    });
});

AC_SERVICES.addListener(EventConstants.TABLE.READY, (event: TableEventPayload) => {
    auto_init_show_more();
    init_actions_tooltips();

    let observer = new MutationObserver(mutations => {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node: HTMLElement) => {
                if (node.tagName === 'TR' && node.classList.contains('iedit')) {
                    $(node).trigger('updated', {id: getIdFromTableRow((<HTMLTableRowElement>node)), row: node})
                }
            });
        });
    });

    observer.observe(event.table.getElement(), {childList: true, subtree: true});

    event.table.Cells.getAll().forEach(cell => {
        cell.events.addListener('setValue', () => {
            auto_init_show_more();
        });
    })


});