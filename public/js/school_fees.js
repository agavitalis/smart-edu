$(document).ready(function() {
    const API_publicKey = "FLWPUBK_TEST-6ed373149166c784cf560090702de235-X";

    function payWithRave(email, amount, phone, scholarship_id,user_id) {
        var x = getpaidSetup({
            PBFPubKey: API_publicKey,
            customer_email: email,
            amount: amount,
            customer_phone: phone,
            currency: "NGN",
            txref: "Applicant-" + email + "-" + scholarship_id,
            meta: [
                {
                    metaname: "Scholarship ID",
                    metavalue: scholarship_id
                },
                {
                    metaname: "User Email",
                    metavalue: email
                }
            ],
            onclose: function() {},
            callback: function(response) {
                var txref = response.data.data.txRef; // collect txRef returned and pass to a server page to complete status check.
                if (
                    response.data.data.chargeResponseCode == "00" ||
                    response.data.data.chargeResponseCode == "0"
                ) {
                    //Log this guy as applied
                    $.ajax({
                        type: "post",
                        url: "/student/finalize_scholarship_application",
                        data: {
                            _token: $("input[name=_token]").val(),
                            scholarship_id: scholarship_id,
                            user_id: user_id,
                            transaction_ref: txref
                        },
                        success: function(response) {
                            if (response.code == 200) {
                        
                                $(".success-message").text(response.message);

                                setTimeout(() => {
                                    window.location.href = response.redirect_url
                                }, 2000);
                                
                                
                            } else if (response.code == 301) {
                                console.log(response.message);
                            }
                        },
                        errors: function(error) {
                            console.log(error.message);
                        }
                    });
                } else {
                    //errrrorr
                    console.log("Error Box:",response.data.data)
                }

                x.close(); // use this to close the modal immediately after payment.
            }
        });
    }

    $(".apply").click(function() {
        let id = $("#profile_id").val();
        let user_id = $("#user_id").val();

        let first_name = $("#first_name").val();
        let last_name = $("#last_name").val();
        let email = $("#email").val();
        let phone = $("#phone").val();
        let category = $('select[name="category"]').val();
        let school_name = $("#school_name").val();
        let level = $("#level").val();
        let exp_year_of_graduation = $("#exp_year_of_graduation").val();
        let country = $("#country").val();
        let state_of_orgin = $("#state_of_orgin").val();
        let lga = $("#lga").val();
        let address = $("#address").val();

        let scholarship_id = $("#scholarship_id").val();
        let amount = $("#application_fee").val();

        if (
            user_id == "" ||
            first_name == "" ||
            last_name == "" ||
            email == "" ||
            phone == "" ||
            category == "" ||
            school_name == "" ||
            level == "" ||
            exp_year_of_graduation == "" ||
            country == "" ||
            state_of_orgin == "" ||
            lga == "" ||
            address == ""
        ) {
            alert("Please fill all fileds");
        } else {
            //Update this guy details and confirm if he is applying for
            //the right scholarship
            $.ajax({
                type: "post",
                url: "/student/scholarship_update_profile",
                data: {
                    _token: $("input[name=_token]").val(),
                    first_name: first_name,
                    last_name: last_name,
                    email: email,
                    phone: phone,
                    category: category,
                    school_name: school_name,
                    level: level,
                    exp_year_of_graduation: exp_year_of_graduation,
                    country: country,
                    state_of_orgin: state_of_orgin,
                    lga: lga,
                    address: address,
                    id: id,
                    user_id: user_id
                },
                success: function(response) {
                    if (response.code == 200) {
                        $(".update-successful").removeClass("d-none");
                        setTimeout(() => {
                            payWithRave(email, amount, phone, scholarship_id, user_id);
                        }, 3000);
                    } else if (response.code == 301) {
                        console.log(response.message);
                        $(".update-error").removeClass("d-none");
                        setTimeout(() => {
                            locacation.reload();
                        }, 2000);

                        $(".withdrawal-message").text(
                            "You don't have any active investment"
                        );
                    }
                },
                errors: function(error) {
                    console.log(error.message);
                }
            });
        }
    });
});
