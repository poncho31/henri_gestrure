import {trim} from "lodash";

export default class general {
    constructor() {
        this.toastTime = 100000;
    }

    cleanSearch(){
        // CLEAN SEARCH
        $('#cleanSearch').on('click', function () {
            $('form input, form textarea, #input_date').not('.notCleanSearch').val("");
            $("select").not('.notCleanSearch').val('test').trigger("change");
        })
    }

    getUrl(e, type, propertyName, propertyValue) {
        let url = new URL(e.target.baseURI);
        let search_params = url.searchParams;
        if (type === 'add') {
            search_params.append(propertyName, propertyValue);
        } else if (type === 'set') {
            search_params.set(propertyName, propertyValue);
        }
        url.search = search_params.toString();
        return url.toString();
    }

    replaceUrlParam(url, paramName, paramValue)
    {
        if (paramValue == null) {
            paramValue = '';
        }
        let pattern = new RegExp('\\b('+paramName+'=).*?(&|#|$)');
        if (url.search(pattern)>=0) {
            return url.replace(pattern,'$1' + paramValue + '$2');
        }
        url = url.replace(/[?#]$/,'');
        return url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue;
    }

    formSerializeArrayKeyValue(thisFormElement){
        let data = { };
        let isFullyFilled = true;
        $.each(thisFormElement.serializeArray(), function() {
            data[this.name] = this.value;
            if(this.value===''){
                isFullyFilled = false;
            }
        });
        return {data:data,fullyFilled:isFullyFilled};
    }

    ajaxSetup(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    /**
     * @param {this} $this this
     * @param {Event} event
     * @param options
     */
    ajaxCallForm($this, event,options={isFullyFilledForm:true,reload:false,toastTime : this.toastTime}){

        console.log($($this));
        let action = trim($($this).find('input[type="submit"]').attr('value'))+"'";
        // let isReloadPage = $($this).hasClass('reload_page_after_job');
        if(confirm("Voulez-vous lancer l'action '" + action)){
            this.ajaxSetup()

            // OPTIONS
            let fullyFilled = true;
            if(options.isFullyFilledForm){
                let formArrayKeyValue = this.formSerializeArrayKeyValue($($this));
                fullyFilled = formArrayKeyValue.fullyFilled;
            }

            if(fullyFilled){
                // AJAX ACTIONS
                $.ajax({
                    url: $($this).attr('action'),
                    method : $($this).attr('method'),
                    data: new FormData($this),
                    processData: false,
                    contentType: false,
                    success: function (e){
                        console.log('success',e);
                        window.ajaxCallFormData = e;
                        showToast(e.toString(),"Job / Action : " + action,'success',options.toastTime);
                    },
                    error: function (e){
                        console.log('error',e);
                        let message = e.hasOwnProperty('responseJSON') ? e.responseJSON.message : e.responseText;
                        message = message === '' ? e.statusText : message;
                        showToast(message,"Job / Action : " + action,'danger',options.toastTime);
                    },
                    complete: function(){
                        // console.log('data', window.ajaxCallFormData)
                        if(options.reload){
                            location.reload();
                        }
                    }
                })
            }
            else{
                showToast('Les entrées du formulaire doivent être complétées.',"Job / Action : " + action,'warning',options.toastTime);
            }
        }
    }
    moveElementByHeader(){
        dragElement(document.getElementById("move"));

        function dragElement(element) {
            let pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
            if (document.getElementById(element.id + "header")) {
                // if present, the header is where you move the DIV from:
                document.getElementById(element.id + "header").onmousedown = dragMouseDown;
            } else {
                // otherwise, move the DIV from anywhere inside the DIV:
                element.onmousedown = dragMouseDown;
            }

            function dragMouseDown(e) {
                e = e || window.event;
                e.preventDefault();
                // get the mouse cursor position at startup:
                pos3 = e.clientX;
                pos4 = e.clientY;
                document.onmouseup = closeDragElement;
                // call a function whenever the cursor moves:
                document.onmousemove = elementDrag;
            }

            function elementDrag(e) {
                e = e || window.event;
                e.preventDefault();
                // calculate the new cursor position:
                pos1 = pos3 - e.clientX;
                pos2 = pos4 - e.clientY;
                pos3 = e.clientX;
                pos4 = e.clientY;
                // set the element's new position:
                element.style.top = (element.offsetTop - pos2) + "px";
                element.style.left = (element.offsetLeft - pos1) + "px";
            }

            function closeDragElement() {
                // stop moving when mouse button is released:
                document.onmouseup = null;
                document.onmousemove = null;
            }
        }
    }

    propertiesToArray(obj) {
        const isObject = val =>
            val && typeof val === 'object' && !Array.isArray(val);

        const addDelimiter = (a, b) =>
            a ? `${a}.${b}` : b;

        const paths = (obj = {}, head = '') => {
            return Object.entries(obj)
                .reduce((product, [key, value]) =>
                {
                    let fullPath = addDelimiter(head, key)
                    return isObject(value) ?
                        product.concat(paths(value, fullPath))
                        : product.concat(fullPath)
                }, []);
        }
        return paths(obj);
    }

    select2(){
        $(document).ready(function(){
            $('select:not(.normal)').each(function(){

                $(this).select2({

                    // PLACEHOLDER
                    placeholder: $(this).attr('placeholder'),
                    dropdownParent: $(this).parent(),

                    // SELECT2 OPTGROUP
                    templateResult: function(item) {
                        if(typeof item.children != 'undefined') {

                            let s = $(item.element).find('option').length - $(item.element).find('option:selected').length;
                            // My optgroup element
                            let el = $('<span class="my_select2_optgroup'+(s ? '' : ' my_select2_optgroup_selected')+'">'+item.text+'</span>');

                            // Click event
                            el.click(function() {
                                let select2 = $('select');
                                // Select all optgroup child if there aren't, else deselect all
                                select2.find('optgroup[label="' + $(this).text() + '"] option').prop(
                                    'selected',
                                    $(item.element).find('option').length - $(item.element).find('option:selected').length
                                );
                                // Trigger change event + close dropdown
                                select2.change();
                                select2.select2('close');
                            });

                            // Hover events to properly manage display
                            el.mouseover(function() {
                                $('li.select2-results__option--highlighted').removeClass('select2-results__option--highlighted');
                            });
                            el.hover(function() {
                                el.addClass('my_select2_optgroup_hovered');
                            }, function() {
                                el.removeClass('my_select2_optgroup_hovered');
                            });
                            return el;
                        }
                        return item.text;
                    }
                })
            })
        })

    }

    arrowKeyNavigation(scope='#arrowNavigation', element ='input'){
        $(scope).keydown(function(e) {
            if (e.key === 'ArrowLeft') {
                navigate(e,scope,element, -1);
            }
            if (e.key === 'ArrowRight') {
                navigate(e, scope,element,1);
            }
            // if (e.key === 'ArrowDown') {
            //     navigate(e.target, 1);
            // }
            // if (e.key === 'ArrowUp') {
            //     navigate(e.target, 1);
            // }
        });

        function navigate(e, scope, element,sens) {
            let inputs = $(scope).find(element);
            let index = inputs.index(e.target);
            index += sens;
            if (index < 0) {
                index = inputs.length - 1;
            }
            if (index > inputs.length - 1) {
                index = 0;
            }
            inputs.eq(index).focus();
        }
    }


    selectTableElements(scope, toggleClass, toggleClassElementToFind,inputSelectedElements){
        let rangeFirst = null;
        let rangeSecond = null;

        $(scope).on('click', 'tr', function (e){
            let $this = $(this);
            // sélection 1 par 1 avec touche CTRL activée
            if(e.ctrlKey)
            {
                rangeFirst = $this.index();
                $this.toggleClass(toggleClass);
            }
            // sélection d'un range avec touche SHIFT activée
            else if(e.shiftKey)
            {
                rangeFirst = rangeFirst === null ? $this.index() : rangeFirst;
                rangeSecond = rangeFirst === null ? null : $this.index();
                if(rangeSecond !== null){
                    $('.'+toggleClass).removeClass(toggleClass);
                    let min = Math.min(...[rangeFirst, rangeSecond]);
                    let max = Math.max(...[rangeFirst, rangeSecond]);
                    $(scope + ' tbody tr').slice(min,max + 1).addClass(toggleClass)
                }
                else{
                    $this.toggleClass(toggleClass);
                }
            }
            // Event par défaut
            else
            {
                rangeFirst = $this.index();
                $('.'+ toggleClass).removeClass(toggleClass);
                $this.toggleClass(toggleClass);
            }

            // Recherche des éléments qui ont la classe 'toggleClass' et push dans ARrray
            let elements = [];
            $('.'+ toggleClass).find(toggleClassElementToFind).each(function (k, elem){
                elements.push($(elem).text());
            });

            // Ajout des éléments dans le 'inputSelectedElements'
            $(inputSelectedElements).val(elements.join(','))
        })
    }


    EventReceive(userId, eventName){
        // EVENT GENERIQUE
        if(eventName === 'userEvent'){
            Echo.private('user.'+userId??'0')
                .listen('BroadcastEventToUserNow', (e) => {
                    console.log('BroadcastEventToUserNow',e);
                    if(e.type === 'extraction'){
                        if(e.isEnd){
                            let popUpNumber = $('#eventDownloadFileUser li').length + 1 ;
                            $('#eventDownloadFileUserPopup').show().html(popUpNumber)
                            $('#eventDownloadFileUser').append(
                                "<li class='nav-item'>" +
                                "    <a class='dropdown-item'" +
                                "       href='http://"+window.location.hostname+":"+window.location.port+"/user/file/download/"+e.data.file.filename+ "'>" +
                                "         <span class='bg-success'>"+popUpNumber+"</span>" +
                                "         <span class='alert-success'>"+e.data.file.filename+"</span> "+
                                "    </a>" +
                                "</li>"
                            )
                        }
                        showToast(e.data.info, 'Extraction', 'primary')
                    }
                })
        }
        else if(eventName === 'itEvent'){
            Echo.private('event.it')
                .listen('BroadcastEventToUserNow', (e) => {
                    console.log('EVENT.IT',e);
                    showToast(e.data.info, '<b>Planificateur des tâches</b>', 'primary')
                })
        }

    }
}







