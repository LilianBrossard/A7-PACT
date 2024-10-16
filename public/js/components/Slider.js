import { WebComponent } from "./WebComponent.js";

/**
 * Button component
 *
 * @arg {string} color - Color of the button. Default is blue
 */
export class Slider extends WebComponent {
    static get observedAttributes() {
        return ["label", "min", "max", "type"];
    }

    constructor() {
        super();

        this.updateRender();
    }

    connectedCallback() {
        super.connectedCallback();
    }

    disconnectedCallback() {}

    attributeChangedCallback(name, oldValue, newValue) {
        if (oldValue !== newValue) {
            this.updateRender();
        }
    }

    styles() {
        return `
            <style>
            .container {
            width: 200px;
            margin: 0 auto;





    }
            [slider] {
            position: relative;
            height: 14px;
            border-radius: 10px;
            text-align: left;
            margin: 45px 0 10px 0;
            }

            [slider] > div {
            position: absolute;
            left: 13px;
            right: 15px;
            height: 14px;
            }

            [slider] > div > [inverse-left] {
            position: absolute;
            left: 0;
            height: 14px;
            border-radius: 10px;
            background-color: #CCC;
            margin: 0 7px;
            }

            [slider] > div > [inverse-right] {
            position: absolute;
            right: 0;
            height: 14px;
            border-radius: 10px;
            background-color: #CCC;
            margin: 0 7px;
            }

            [slider] > div > [range] {
            position: absolute;
            left: 0;
            height: 14px;
            border-radius: 14px;
            background-color: #1ABC9C;
            }

            [slider] > div > [thumb] {
            position: absolute;
            top: -7px;
            z-index: 2;
            height: 28px;
            width: 28px;
            text-align: left;
            margin-left: -11px;
            cursor: pointer;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.4);
            background-color: #FFF;
            border-radius: 50%;
            outline: none;
            }

            [slider] > input[type=range] {
            position: absolute;
            pointer-events: none;
            -webkit-appearance: none;
            z-index: 3;
            height: 14px;
            top: -2px;
            width: 100%;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
            filter: alpha(opacity=0);
            -moz-opacity: 0;
            -khtml-opacity: 0;
            opacity: 0;
            }

            div[slider] > input[type=range]::-ms-track {
            -webkit-appearance: none;
            background: transparent;
            color: transparent;
            }

            div[slider] > input[type=range]::-moz-range-track {
            -moz-appearance: none;
            background: transparent;
            color: transparent;
            }

            div[slider] > input[type=range]:focus::-webkit-slider-runnable-track {
            background: transparent;
            border: transparent;
            }

            div[slider] > input[type=range]:focus {
            outline: none;
            }

            div[slider] > input[type=range]::-ms-thumb {
            pointer-events: all;
            width: 28px;
            height: 28px;
            border-radius: 0px;
            border: 0 none;
            background: red;
            }

            div[slider] > input[type=range]::-moz-range-thumb {
            pointer-events: all;
            width: 28px;
            height: 28px;
            border-radius: 0px;
            border: 0 none;
            background: red;
            }

            div[slider] > input[type=range]::-webkit-slider-thumb {
            pointer-events: all;
            width: 28px;
            height: 28px;
            border-radius: 0px;
            border: 0 none;
            background: red;
            -webkit-appearance: none;
            }

            div[slider] > input[type=range]::-ms-fill-lower {
            background: transparent;
            border: 0 none;
            }

            div[slider] > input[type=range]::-ms-fill-upper {
            background: transparent;
            border: 0 none;
            }

            div[slider] > input[type=range]::-ms-tooltip {
            display: none;
            }

            [slider] > div > [sign] {
            opacity: 0;
            position: absolute;
            margin-left: -11px;
            top: -39px;
            z-index: 3;
            background-color: #1ABC9C;
            color: #fff;
            width: 28px;
            height: 28px;
            border-radius: 28px;
            -webkit-border-radius: 28px;
            align-items: center;
            -webkit-justify-content: center;
            justify-content: center;
            text-align: center;
            }

            [slider] > div > [sign]:after {
            position: absolute;
            content: '';
            left: 0;
            border-radius: 16px;
            top: 19px;
            border-left: 14px solid transparent;
            border-right: 14px solid transparent;
            border-top-width: 16px;
            border-top-style: solid;
            border-top-color: #1ABC9C;
            }

            [slider] > div > [sign] > span {
            font-size: 12px;
            font-weight: 700;
            line-height: 28px;
            }

            [slider]:hover > div > [sign] {
            opacity: 1;
            }
            </style>
        `;
    }

    render() {
        if (this.getAttribute("type") === "minmax") {
            return `
            <div class="container">
            <div slider id="slider-distance">
                <div>
                    <div inverse-left style="width:70%;"></div>
                    <div inverse-right style="width:70%;"></div>
                    <div range style="left:30%;right:40%;"></div>
                    <span thumb style="left:30%;"></span>
                    <span thumb style="left:60%;"></span>
                    <div sign style="left:30%;">
                        <span id="value">30</span>
                    </div>
                    <div sign style="left:60%;">
                        <span id="value">60</span>
                    </div>
                </div>
                <input type="range" tabindex="0" value="30" max="100" min="0" step="1" oninput="
                    this.value=Math.min(this.value,this.parentNode.childNodes[5].value-1);
                    var value=(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.value)-(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.min);
                    var children = this.parentNode.childNodes[1].childNodes;
                    children[1].style.width=value+'%';
                    children[5].style.left=value+'%';
                    children[7].style.left=value+'%';
                    children[11].style.left=value+'%';
                    children[11].childNodes[1].innerHTML=this.value;" />
                <input type="range" tabindex="0" value="60" max="100" min="0" step="1" oninput="
                    this.value=Math.max(this.value,this.parentNode.childNodes[3].value-(-1));
                    var value=(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.value)-(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.min);
                    var children = this.parentNode.childNodes[1].childNodes;
                    children[3].style.width=(100-value)+'%';
                    children[5].style.right=(100-value)+'%';
                    children[9].style.left=value+'%';
                    children[13].style.left=value+'%';
                    children[13].childNodes[1].innerHTML=this.value;" />
            </div>
        </div>
            `;
        } else {
            return `
            <div class="container">
                <div class="labels">
                    <span>${this.getAttribute("label")}</span>
                    <span>${document.getElementById("")}</span>
                </div>
                
                <div>
                    <div class="range">
                    <input type="range">
                    

                </div>

            </div>
            `;
        }
    }

    updateRender() {
        this.shadowRoot.innerHTML = this.styles() + this.render();
    }
    // ---------------------------------------------------------------------- //
    // Other methods
    // ---------------------------------------------------------------------- //
}