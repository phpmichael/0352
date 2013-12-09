var appPackages = {};

//package: tell_friend
appPackages.tell_friend = {};
appPackages.tell_friend.form_action = "<?=relative_url($BC->_getBaseURL()."tell_friend/send")?>";
appPackages.tell_friend.messages = {};
appPackages.tell_friend.messages.your_message_sent = "<?=language('your_message_sent')?>";

//package: contact_us
appPackages.contact_us = {};
appPackages.contact_us.form_action = "<?=relative_url($BC->_getBaseURL()."contact_us/send")?>";
appPackages.contact_us.messages = {};
appPackages.contact_us.messages.your_message_sent = "<?=language('your_message_sent')?>";

//package: subscribe
appPackages.subscribe = {};
appPackages.subscribe.form_action = "<?=relative_url($BC->_getBaseURL()."subscribe/insert_email")?>";
appPackages.subscribe.form_action_unsubscribe = "<?=relative_url($BC->_getBaseURL()."subscribe/do_unsubscribe")?>";

//package: ratings
appPackages.ratings = {};
appPackages.ratings.form_action = "<?=relative_url($BC->_getBaseURL()."ratings/set")?>";

//package: comments
appPackages.comments = {};
appPackages.comments.form_action = "<?=relative_url($BC->_getBaseURL()."comments/add")?>";

//package: wishlist
appPackages.wishlist = {};
appPackages.wishlist.form_action = "<?=relative_url($BC->_getBaseURL()."wishlist/add")?>";

//package: shop
appPackages.shop = {};
appPackages.shop.cart_url = "<?=relative_url($BC->_getBaseURL()."cart")?>";
appPackages.shop.short_cart_url = "<?=relative_url($BC->_getBaseURL()."cart/short")?>";
appPackages.shop.dialog_cart_url = "<?=relative_url($BC->_getBaseURL()."cart/dialog")?>";
appPackages.shop.show_dialog_cart = "<?=@$BC->settings_model['show_dialog_cart']?>";

//package: customers
appPackages.customers = {};
appPackages.customers.check_email_exists_url = "<?=relative_url($BC->_getBaseURL()."customers/check_email")?>";

//package: request_call
appPackages.request_call = {};
appPackages.request_call.form_action = "<?=relative_url($BC->_getBaseURL()."request_call/send")?>";
appPackages.request_call.content_url = "<?=relative_url($BC->_getBaseURL()."request_call")?>";
appPackages.request_call.title = "<?=language('request_a_call')?>";
appPackages.request_call.messages = {};
appPackages.request_call.messages.sent = "<?=language('your_request_sent')?>";