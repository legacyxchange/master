<style>
.admin-menu a {
padding-top: 1px;
padding-left: 5PX;
padding-right: 5px;
padding-bottom: 0px;
font-size: 11px;
letter-spacing: 1px;
border-bottom-left-radius: 0px;
border-bottom-right-radius: 0px;
margin-bottom:-40px;
background-color: #969696;
border-radius: 5px;
padding-top:3px;
padding-bottom:3px;
color: #fff;
margin:-0px;
border-bottom-left-radius: 0px;
border-bottom-right-radius: 0px;

width:120px;
}
</style>

<div class="admin-menu" style="background:#fff;margin-bottom:-21px;">
	<a <?php echo !empty($menu_account) ? 'style="background:#006989;color:#fff;"' : ''; ?> class="btn btn-default" href="/admin/account">MY ACCOUNT</a>
	<a <?php echo !empty($menu_settings) ? 'style="background:#006989;color:#fff;"' : ''; ?> class="btn btn-default" href="/admin/settings">MY SETTINGS</a>
    <a <?php echo !empty($menu_products) ? 'style="background:#006989;color:#fff;"' : ''; ?> class="btn btn-default" href="/admin/products">MY PRODUCTS</a>
    <a <?php echo !empty($menu_bids) ? 'style="background:#006989;color:#fff;"' : ''; ?> class="btn btn-default" href="/admin/bids">MY BIDS</a>
    <a <?php echo !empty($menu_purchases) ? 'style="background:#006989;color:#fff;"' : ''; ?> class="btn btn-default" href="/admin/purchases">MY PURCHASES</a>
    <a <?php echo !empty($menu_sales) ? 'style="background:#006989;color:#fff;"' : ''; ?> class="btn btn-default" href="/admin/sales">MY SALES</a>
    <a <?php echo !empty($menu_store) ? 'style="background:#006989;color:#fff;"' : ''; ?> class="btn btn-default" href="/admin/store">MY STORE</a>
    <a <?php echo !empty($menu_notifications) ? 'style="background:#006989;color:#fff;"' : ''; ?> class="btn btn-default" href="/admin/notifications">MY NOTIFICATIONS</a>
</div>