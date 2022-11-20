<?php
use ICWX\Tools\Url;
?>
<div class="wrap">
    <h1>Импорт записей с комментариями</h1>

    <?php if (!empty($fatalError)) { ?>
        <div class="inline notice notice-error">
            <p>
                При выполнении импорта произошла ошибка. Подробности:
            </p>
        </div>

        <textarea readonly cols="50" rows="10" class="large-text code"><?php
            echo $fatalError;
        ?></textarea>
    <?php } ?>

    <?php if (!empty($errors)) {
        foreach ($errors as $error) { ?>
            <div class="inline notice notice-error">
                <p>
                    <?php echo $error; ?>
                </p>
            </div>
        <?php }
    } ?>

    <form enctype="multipart/form-data" action="<?php echo Url::page('execute'); ?>" method="POST">
        <?php wp_nonce_field('icwx_import'); ?>

        <input type="hidden" name="action" value="icwx_import">

        <h2>Файл импорта (xml)</h2>
        <input type="file" name="xml" accept=".xml">

        <p>
            <label>
                <input type="checkbox" name="disable_kses" value="1">

                Отключить kses-фильтры
            </label>
        </p>

        <p>
            <label for="post-status" class="label-responsive"><?php _e( 'Status:' ); ?></label>
            <select name="post_status" id="post-status">
                <?php
                $post_stati = get_post_stati( array( 'internal' => false ), 'objects' );
                unset($post_stati['future']);
                foreach ( $post_stati as $status ) :
                    ?>
                    <option value="<?php echo esc_attr( $status->name ); ?>"><?php echo esc_html( $status->label ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p class="submit">
            <button class="button button-primary">Запустить</button>
        </p>
    </form>
</div>