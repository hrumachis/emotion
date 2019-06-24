const messagesElm = $( '#messages' ); // array
const fullNameElm = $( '#fullname' ); // input
const emailElm = $( '#email' ); // input
const birthdateElm = $( '#birthdate' ); // input
const messageElm = $( '#message' ); // input
const loadingElm = $( '#loading' ); // img
const submitElm = $( '#submit' ); // button
const api = new Api();

/**
 * Submit form function
 * Sends fields data to api
 * Toggles visuals
 * 
 * @param { Event } event 
 */
function onSubmitEvent( event ) {
    event.preventDefault();

    disableButtonSubmit( true );
    disableInputFields( true );

    setTimeout( function() {
        api.postMessage( fullNameElm.val(), emailElm.val(), birthdateElm.val(), messageElm.val(), function( data ) {
            if ( data.res != undefined ) {
                let res = data.res;
                console.log( data );
    
                if ( res.errors != undefined ) {
                    setFieldError( fullNameElm, res.errors.fullName != undefined );
                    setFieldError( emailElm, res.errors.email != undefined );
                    setFieldError( birthdateElm, res.errors.birthdate != undefined );
                    setFieldError( messageElm, res.errors.message != undefined );
                } else if ( res.success ) {
                    setFieldError( fullNameElm, false );
                    setFieldError( emailElm, false );
                    setFieldError( birthdateElm, false );
                    setFieldError( messageElm, false );

                    addNewMessage( fullNameElm.val(), emailElm.val(), messageElm.val(), data.res.age );
                    removeLastMessage();
                }
            }
    
            disableButtonSubmit( false );
            disableInputFields( false );
        } );
    }, 1000 ); // Time for visual effect to appear
}

/**
 * 
 * @param { string } fullName 
 * @param { string } email 
 * @param { string } message 
 * @param { mixed } age 
 */
function addNewMessage( fullName, email, message, age ) {
    let element = "<li><span>" + currentTime() + "</span>";
    
    if ( email.length > 0 ) {
        element += "<a href=\"mailto:\"" + email + ">" + fullName + "</a>";
    } else {
        element += fullName;
    }

    element += ", " + age + "m <br/>" + message + "</li>";

    messagesElm.prepend( element );
}

/**
 * @return { string }
 */
function currentTime() {
    var today = new Date();
    var date = today.getFullYear()+'-'+( today.getMonth()+1 )+'-'+today.getDate();
    var time = ( ( today.getHours() + 24 ) % 12 || 12 ) + ":" + today.getMinutes();

    return date+' '+time;
}

/**
 * Remove last message
 */
function removeLastMessage() {
    messagesElm.children()[ messagesElm.children().length-1 ].remove();
}

/**
 * Toggle "err" class to field
 */
function setFieldError( element, state ) {
    if ( state )
        element.parent().addClass( "err" );
    else
        element.parent().removeClass( "err" );
}

/**
 * Disable input fields
 * 
 * @param { boolean } state 
 */
function disableInputFields( state ) {
    if ( state ) {
        fullNameElm.attr( 'disabled', 'disabled' );
        emailElm.attr( 'disabled', 'disabled' );
        birthdateElm.attr( 'disabled', 'disabled' );
        messageElm.attr( 'disabled', 'disabled' );
    } else {
        fullNameElm.removeAttr( 'disabled' );
        emailElm.removeAttr( 'disabled' );
        birthdateElm.removeAttr( 'disabled' );
        messageElm.removeAttr( 'disabled' );
    }
    
}

/**
 * Toggle button and loading indicator visibility
 * 
 * @param { boolean } state 
 */
function disableButtonSubmit( state ) {
    if ( state ) {
        loadingElm.removeClass( 'hidden' );
        submitElm.addClass( 'hidden' );
    } else {
        loadingElm.addClass( 'hidden' );
        submitElm.removeClass( 'hidden' );
    }
}