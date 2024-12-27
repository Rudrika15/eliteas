$(document).ready(function () {
    function showInternalTrainerData() {
        $.ajax({
            url: "/get-internal-trainer-details",
            dataType: "json",
            success: function (data) {
                if (data && data.length > 0) {
                    var internalTrainerDetails = "";
                    data.forEach(function (trainer) {
                        console.log(trainer);
                        if (trainer.users) {
                            // Check if 'users' property exists
                            internalTrainerDetails +=
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
                                trainer.users.contactNo +
                                "</p>" +
                                "</div>";
                            console.log(internalTrainerDetails);
                        } else {
                            console.error(
                                "No user data found for trainer:",
                                trainer
                            );
                        }
                    });

                    // Update modal content
                    $(".internalTrainerDetails").html(internalTrainerDetails);
                    console.log(internalTrainerDetails);
                    // Handle click event on trainer-card
                    $(".trainer-card").click(function () {
                        var trainerId = $(this).data("trainer-id");
                        var trainerName = $(this)
                            .find(".card-title")
                            .text();
                        var trainerEmail = $(this).find(".email").text();
                        var contactNo = $(this).find(".mobile").text();

                        $("#trainerId").val(trainerId);
                        $("#trainerName").val(trainerName);
                        $("#trainerEmail").val(trainerEmail);
                        $("#trainerContact").val(contactNo);

                        // Close the modal
                        $("#internalTrainerMaster").modal("hide");
                    });

                    // Show the modal
                    $("#internalTrainerMaster").modal("show");
                } else {
                    $(".internalTrainerDetails").html(
                        "<p>Trainer details not found.</p>"
                    );
                    $("#internalTrainerMaster").modal("show");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching trainer details:", error);
                $(".internalTrainerDetails").html(
                    "<p>Error fetching trainer details.</p>"
                );
                $("#internalTrainerMaster").modal("show");
            },
        });
    }

    // Trigger the function when the button is clicked
    $("button[data-bs-target='#internalTrainerMaster']").click(function () {
        showInternalTrainerData();
    });
});
