import AcHtmlElement from "../../helpers/html-element";
import {initAcServices} from "../../helpers/admin-columns";
import AcServices from "../../modules/ac-services";
import {Form} from "./form";
import {LocalizedAcColumnSettings} from "../../types/admin-columns";

declare const AC: LocalizedAcColumnSettings;

export default class RemoveColumns {

    private element: HTMLAnchorElement
    private services: AcServices;

    constructor( services: AcServices  ) {
        this.element = AcHtmlElement.create('a').addClass('ac-clear-columns').addHtml(AC.i18n.clear_columns ).element as HTMLAnchorElement;
        this.services = services;
        this.init();
    }

    getElement(){
        return this.element
    }

    init() {
        this.element.addEventListener('click', (e) => {
            e.preventDefault();

            if (this.services.hasService('Form')) {
                this.services.getService<Form>('Form').resetColumns();
            }
        });
    }

}