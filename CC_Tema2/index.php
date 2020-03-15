<div class="center">
    <div class="item">
        <span>
            Method:
        </span>
        <select id="method" onchange="updateMethod()">
            <option value="GET">GET</option>
            <option value="POST">POST</option>
            <option value="PUT">PUT</option>
            <option value="DELETE">DELETE</option>
        </select>
    </div>
    
    <div class="item">
        <div id="post">
            <input type="text" id="last_name" placeholder="last name"/>
            <input type="text" id="first_name" placeholder="first name"/>
            <input type="text" id="age" placeholder="age"/>
            <input type="text" id="height" placeholder="height"/>
            <input type="text" id="telephone" placeholder="telephone"/>
            <input type="text" id="email" placeholder="email"/>
        </div>
    </div>
    
    <div class="item">
        <span>
            Route:
        </span>
        <select id="route">
            <option value="entities">entities</option>
        </select>
    </div>
    
    <div class="item">
        <span>
            Entity ID:
        </span>
        <input type="text" id="entity"/>
    </div>
    
    <div class="item">
        <button onclick="callApi()">Call</button>
    </div>
    
    <div class="item">
        <span id="response"></span>
    </div>
</div>

<script>
    function callApi () {
        let method = document.getElementById( 'method' ).value;
        let route = document.getElementById( 'route' ).value;
        let entityId = document.getElementById( 'entity' ).value;

        if ( method === 'GET' ) {

            let url = 'http://localhost:8001/apiCall.php/' + route + '/' + entityId;

            var xhr = new XMLHttpRequest();
            xhr.onload = function() {
                let data = JSON.parse( xhr.responseText );
                document.getElementById( 'response' ).innerText = 'Status: ' + data['status'];
            };
            xhr.open( 'GET', url );
            xhr.send();
        }
        else if ( method === "POST" ) {
            let data = {
                first_name : document.getElementById( 'first_name' ).value,
                last_name  : document.getElementById( 'last_name' ).value,
                age        : document.getElementById( 'age' ).value,
                height     : document.getElementById( 'height' ).value,
                telephone  : document.getElementById( 'telephone' ).value,
                email      : document.getElementById( 'email' ).value,
            };

            params = Object.keys( data ).map(
                    function( k ) { return encodeURIComponent( k ) + '=' + encodeURIComponent( data[k] ) }
            ).join( '&' );

            let url = 'http://localhost:8001/apiCall.php/' + route;

            var xhr = new XMLHttpRequest();
            xhr.onload = function() {
                let data = JSON.parse( xhr.responseText );
                document.getElementById( 'response' ).innerText = 'Status: ' + data['status'];
            };
            xhr.open( 'POST', url );
            xhr.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded; charset=UTF-8" );
            xhr.send(params);
        }
        else if ( method === 'DELETE') {
            let url = 'http://localhost:8001/apiCall.php/' + route + '/' + entityId;
            
            var xhr = new XMLHttpRequest();
            xhr.onload = function() {
                let data = JSON.parse( xhr.responseText );
                document.getElementById( 'response' ).innerText = 'Status: ' + data['status'];
            };
            xhr.open( 'DELETE', url );
            xhr.send();
        }
        else if ( method === 'PUT'){
            let data = {
                first_name : document.getElementById( 'first_name' ).value,
                last_name  : document.getElementById( 'last_name' ).value,
                age        : document.getElementById( 'age' ).value,
                height     : document.getElementById( 'height' ).value,
                telephone  : document.getElementById( 'telephone' ).value,
                email      : document.getElementById( 'email' ).value,
            };

            params = Object.keys( data ).map(
                    function( k ) { return encodeURIComponent( k ) + '=' + encodeURIComponent( data[k] ) }
            ).join( '&' );

            let url = 'http://localhost:8001/apiCall.php/' + route;

            var xhr = new XMLHttpRequest();
            xhr.onload = function() {
                let data = JSON.parse( xhr.responseText );
                document.getElementById( 'response' ).innerText = 'Status: ' + data['status'];
            };
            xhr.open( 'PUT', url );
            xhr.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded; charset=UTF-8" );
            xhr.send( params );
        }


    }

</script>

<style>
    .center {
        margin         : 100px auto;
        text-align     : center;
        display        : flex;
        flex-direction : column;
    }

    .item {
        margin-top : 50px;
    }

    .method-option {
        display : none;
    }
</style>
