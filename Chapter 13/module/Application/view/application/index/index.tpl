{extends 'layout/layout.tpl'}
{block 'content'}
    <div class="jumbotron">
        <h1><span class="zf-green">User from DB test</span></h1>
        <p>
            Found user:<br /><br />
            Id: {$id}<br />
            Username: {$username}<br />
            Password: {$password}
        </p>
    </div>
{/block}