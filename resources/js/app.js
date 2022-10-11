window.$ = window.jquery  = require( "jquery" );
import './bootstrap';



// OWN CLASS
import Record from "./record";
window.recordFunction = new Record()

import General from "./general";
window.ajaxCallFormData = [];
window.general = new General()

general.cleanSearch()
general.ajaxSetup()
general.select2()

// Init form for JOB
$(document).on('submit change','form.job',function(event){
    event.preventDefault();

    let options = {
        isFullyFilledForm       : !$(this).hasClass('nocheck_empty_formfields'),
        reload                  : $(this).hasClass('refresh_page'),
        updateAutomaticOnChange : $(this).hasClass('updateAutomaticOnChange'),
        toastTime               : 10000
    };
    console.log(options)

    if(event.type==='change' && options.updateAutomaticOnChange){
        general.ajaxCallForm(this, event, options);
    }
    else if(event.type === 'submit'){
        general.ajaxCallForm(this, event, options);
    }
});
