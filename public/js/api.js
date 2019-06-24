/**
 * Api class
 */
function Api() {
    var self = this;
    this.busy = false;

    /**
     * Post message
     * 
     * @param { string } fullName
     * @param { string } email
     * @param { string } birthdate
     * @param { string } message
     * @param { function } callback
     */
    this.postMessage = function( fullName, email, birthdate, message, callback ) {
        if ( !this.busy ) {
            this.busy = true;

            $.ajax( {
                type: "POST",
                contentType: "application/json; charset=utf-8",
                url: "?action=sendMessage&fullName=" + fullName + "&email=" + email + "&birthdate=" + birthdate + "&message=" + message,
                success: function ( data ) {
                    callback( data );
                    self.busy = false;
                },
                error: function( e ) {
                    console.log( "Error 404" );
                    callback( {} );
                    self.busy = false;
                }
            });
        }
    }
}