class Tooltip {

    constructor(wrapperElement, tooltipElement) {
        this.wrapper = wrapperElement;
        this.tooltip = tooltipElement;

        this.createTooltip();
        this.hangEvents();
    }

    createTooltip() {
        this.popper = Popper.createPopper(this.wrapper, this.tooltip, {
            placement: 'right',
            modifiers: [
                {
                    name: 'offset',
                    options: {
                        offset: [0, 8]
                    }
                }
            ]
        })
    }

    hangEvents() {
        this.wrapper.addEventListener('mouseenter', () => {
            this.tooltip.setAttribute('data-show', '');
            this.popper.update();
        });

        this.wrapper.addEventListener('mouseleave', () => {
            this.tooltip.removeAttribute('data-show');
        });
    }
}