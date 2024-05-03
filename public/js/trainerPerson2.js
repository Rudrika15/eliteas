$(document).ready(function () {
    function showInternalTrainerData2() {
        $.ajax({
            url: "/get-internal-trainer-details",
            dataType: "json",
            success: function (data) {
                if (data && data.length > 0) {
                    var internalTrainerDetails2 = "";
                    data.forEach(function (trainer) {
                        console.log(trainer);
                        if (trainer.users) {
                            // Check if 'users' property exists
                            internalTrainerDetails2 +=
                                '<div class="card mb-3 mr-3 text-center trainer-card" data-trainer-id="' +
                                trainer.userId + // Assuming 'id' is the user's ID in TrainerMaster model
                                '">' +
                                '<h5 class="card-title" style="font-size:20px; color:1D2856;">' +
                                trainer.users.firstName + // Assuming 'first_name' and 'last_name' are fields in the 'users' relationship
                                " " +
                                trainer.users.lastName +
                                "</h5>" +
                                '<p class="card-text lead email" style="font-size:20px; color:grey;">' +
                                trainer.users.email +
                                "</p>" +
                                '<p class="card-text lead mobile" style="font-size:20px; color:grey;">' +
                                trainer.members.mobileNo +
                                "</p>" +
                                "</div>";
                            console.log(internalTrainerDetails2);
                        } else {
                            console.error(
                                "No user data found for trainer:",
                                trainer
                            );
                        }
                    });

                    // Update modal content
                    $(".internalTrainerDetails2").html(internalTrainerDetails2);
                    console.log(internalTrainerDetails2);
                    // Handle click event on trainer-card
                    $(".trainer-card").click(function () {
                        var trainerId = $(this).data("trainer-id");
                        var trainerName2 = $(this).find(".card-title").text();
                        var trainerEmail2 = $(this).find(".email").text();
                        var contactNo2 = $(this).find(".mobile").text();

                        $("#trainerId2").val(trainerId);
                        $("#trainerName2").val(trainerName2);
                        $("#trainerEmail2").val(trainerEmail2);
                        $("#contactNo2").val(contactNo2);

                        // Close the modal
                        $("#internalTrainerMaster2").modal("hide");
                    });

                    // Show the modal
                    $("#internalTrainerMaster2").modal("show");
                } else {
                    $(".internalTrainerDetails2").html(
                        "<p>Trainer details not found.</p>"
                    );
                    $("#internalTrainerMaster2").modal("show");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching trainer details:", error);
                $(".internalTrainerDetails2").html(
                    "<p>Error fetching trainer details.</p>"
                );
                $("#internalTrainerMaster2").modal("show");
            },
        });
    }

    // Trigger the function when the button is clicked
    $("button[data-bs-target='#internalTrainerMaster2']").click(function () {
        showInternalTrainerData2();
    });
});
