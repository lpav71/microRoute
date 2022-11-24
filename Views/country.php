<div id="app">
    <div class="container">
        <table class="table table-hover" style="margin-top: 35px;">
            <tbody>
            <?php
            foreach ($rows as $c) : ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= $c['name'] ?></td>
                </tr>
            <?php
            endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
