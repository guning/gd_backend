<template>
    <nav class="navbar navbar-inverse navbar-fixed-top" id="nav">
        <div class="container-fluid">
            <div class="navbar-header">
                <!--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>-->
                <a class="navbar-brand" href="/">MQTT Push</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!--<li><a href="#">Push</a></li>-->
                    <!--<li><a href="#">Manage</a></li>-->
                    <!--<li><a href="#">Dashboard</a></li>-->
                    <li>
                        <div class="gplaceholder"><img
                                src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=="
                                width="50" height="50" class="img-responsive" alt="Generic placeholder thumbnail"></div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
    export default {
        name: 'nav',
        props: []
    }
</script>
