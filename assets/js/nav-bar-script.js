// redirects to home page after clicking the logo
$(".logo-img").click(()=> {
    $(location).attr('href','/home.php');
});

// redirects to cart page whent he shopping cart is clicked
$(".fa-comment-alt").click(()=> {
    $(location).attr('href','/home.php');
});

// redirects to cart page whent he shopping cart is clicked
$(".fa-plus-square").click(()=> {
    $(location).attr('href','');
});

// redirects to cart page whent he shopping cart is clicked
$(".fa-user").click(()=> {
    $(location).attr('href','/account.php');
});