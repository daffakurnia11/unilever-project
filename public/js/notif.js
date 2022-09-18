const flashdata = $("#flash-data").data("flashdata");

if (flashdata) {
    // Login Gagal
    if (flashdata == "Login Failed") {
        Swal.fire({
            icon: "error",
            title: "Access Denied!",
            text: "Wrong username or password, please try again!",
            confirmButtonColor: "#c6384d",
        });
    }
}
