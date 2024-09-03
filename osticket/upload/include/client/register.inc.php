<?php
$info = $_POST;
if (!isset($info['timezone']))
    $info += array(
        'backend' => null,
    );
if (isset($user) && $user instanceof ClientCreateRequest) {
    $bk = $user->getBackend();
    $info = array_merge($info, array(
        'backend' => $bk->getBkId(),
        'username' => $user->getUsername(),
    ));
}
$info = Format::htmlchars(($errors && $_POST)?$_POST:$info);

?>
<h1><?php echo __('Registrasi Akun'); ?></h1>
<p><?php echo __(
'Gunakan formulir di bawah ini untuk membuat atau memperbarui informasi yang kami simpan untuk akun Anda'
); ?>
</p>
<form action="account.php" method="post">
  <?php csrf_token(); ?>
  <input type="hidden" name="do" value="<?php echo Format::htmlchars($_REQUEST['do']
    ?: ($info['backend'] ? 'import' :'create')); ?>" />
<table width="800" class="padded">
<tbody>
<?php
    $cf = $user_form ?: UserForm::getInstance();
    $cf->render(array('staff' => false, 'mode' => 'create'));
?>
<tr>
    <td colspan="2">
        <div><hr><h3><?php echo __('Preferensi'); ?></h3>
        </div>
    </td>
</tr>
    <tr>
        <td width="180">
            <?php echo __('Zona Waktu');?>:
        </td>
        <td>
            <?php
            $TZ_NAME = 'timezone';
            $TZ_TIMEZONE = $info['timezone'];
            include INCLUDE_DIR.'staff/templates/timezone.tmpl.php'; ?>
            <div class="error"><?php echo $errors['timezone']; ?></div>
        </td>
    </tr>
<tr>
    <td colspan=2">
        <div><hr><h3><?php echo __('Akses Kredensial'); ?></h3></div>
    </td>
</tr>
<?php if ($info['backend']) { ?>
<tr>
    <td width="180">
        <?php echo __('Masuk dengan'); ?>:
    </td>
    <td>
        <input type="hidden" name="backend" value="<?php echo $info['backend']; ?>"/>
        <input type="hidden" name="username" value="<?php echo $info['username']; ?>"/>
<?php foreach (UserAuthenticationBackend::allRegistered() as $bk) {
    if ($bk->getBkId() == $info['backend']) {
        echo $bk->getName();
        break;
    }
} ?>
    </td>
</tr>
<?php } else { ?>
<tr>
    <td width="180">
        <?php echo __('Password'); ?>:
    </td>
    <td>
        <input type="password" size="18" name="passwd1" maxlength="128" value="<?php echo $info['passwd1']; ?>">
        &nbsp;<span class="error">&nbsp;<?php echo $errors['passwd1']; ?></span>
    </td>
</tr>
<tr>
    <td width="180">
        <?php echo __('Konfirmasi Password Diatas'); ?>:
    </td>
    <td>
        <input type="password" size="18" name="passwd2" maxlength="128" value="<?php echo $info['passwd2']; ?>">
        &nbsp;<span class="error">&nbsp;<?php echo $errors['passwd2']; ?></span>
    </td>
</tr>
<?php } ?>
</tbody>
</table>
<hr>
<p style="text-align: center;">
    <input type="submit" value="<?php echo __('Registrasi'); ?>"/>
    <input type="button" value="<?php echo __('Batal'); ?>" onclick="javascript:
        window.location.href='index.php';"/>
</p>
</form>
<?php if (!isset($info['timezone'])) { ?>
<!-- Auto detect client's timezone where possible -->
<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jstz.min.js?0375576"></script>
<script type="text/javascript">
$(function() {
    var zone = jstz.determine();
    $('#timezone-dropdown').val(zone.name()).trigger('change');
});
</script>
<?php }
