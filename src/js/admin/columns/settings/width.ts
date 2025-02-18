import {Column} from "../column";
import Nanobus from "nanobus";
// @ts-ignore
import $ from 'jquery';

export const initWidthSetting = (column: Column) => {
    column.getElement().querySelectorAll<HTMLElement>('table[data-setting="width"]').forEach(setting => new WidthSetting(column, setting));
}

type widthValue = {
    width: number
    unit: string
}

class WidthSetting {
    column: Column
    setting: HTMLElement
    events: Nanobus
    indicator: WidthIndicator
    widthInput: HTMLInputElement
    unitInput: NodeListOf<HTMLInputElement>

    constructor(column: Column, setting: HTMLElement) {
        this.column = column;
        this.setting = setting;
        this.events = new Nanobus();
        this.indicator = new WidthIndicator(column.getElement().querySelector('.ac-column-heading-setting--width'));
        this.widthInput = this.setting.querySelector<HTMLInputElement>('[data-width-input]');
        this.unitInput = this.setting.querySelectorAll<HTMLInputElement>('[data-unit-input] input')

        this.init();
    }

    getWidth(): number {
        let widthValue = this.widthInput.value;
        return widthValue ? parseInt(widthValue) : null
    }

    setWidth(width: number) {
        this.widthInput.value = width ? width.toString() : null;
        this.updateIndicator();
    }

    updateUnit() {
        this.setting.querySelector('.description .unit').innerHTML = this.getUnit();
    }

    getUnit(): string {
        let input = this.setting.querySelector<HTMLInputElement>('[data-unit-input] input:checked');

        return input ? input.value : null;
    }

    getValue(): widthValue {
        return {
            width: this.getWidth(),
            unit: this.getUnit()
        }
    }

    validate() {
        let width = this.getWidth();

        if (width === 0 || width < 0) {
            this.setWidth(null);
        }

        if (this.getUnit() === '%') {
            if (width > 100) {
                this.setWidth(100);
            }
        }
    }

    init() {
        this.widthInput.addEventListener('keyup', () => {
            this.updateIndicator();
            this.initSlider();
            this.validate();
        });

        this.unitInput.forEach(el => {
            el.addEventListener('change', () => {
                this.initSlider();
                this.updateIndicator();
                this.updateUnit();
                this.validate();
            });
        });

        this.initSlider();
    }

    updateIndicator() {
        this.indicator.setValue(this.getWidth(), this.getUnit())
    }

    initSlider() {
        let sliderElement: HTMLElement = this.column.getElement().querySelector('.width-slider');

        (<any>$(sliderElement)).slider({
            range: 'min',
            min: 0,
            max: '%' === this.getUnit() ? 100 : 500,
            value: this.getWidth(),
            slide: (event: any, ui: any) => {
                this.setWidth(ui.value);
            }
        });
    }
}

class WidthIndicator {

    element: HTMLElement
    events: Nanobus

    constructor(element: HTMLElement) {
        this.element = element;
        this.events = new Nanobus();
    }

    setValue(width: number, unit: string) {
        if (width === null) {
            return this.element.innerText = '';
        }

        this.element.innerText = `${width.toString()}${unit}`;
    }

}