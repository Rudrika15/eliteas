$(document).ready(function () {
    function showTrainerData() {
        $.ajax({
            url: "/get-trainer-details",
            dataType: "json",
            success: function (data) {
                if (data && data.length > 0) {
                    var trainerDetails = "";
                    data.forEach(function (trainer) {
                        // console.log(trainer);

                        trainerDetails +=
                            '<div class="card mb-3 mr-3 text-center trainer-card" data-trainer-id="' +
                            trainer.userId +
                            '">' +
                            // trainer.userId +
                            // '<div class="card-body text-center">' +
                            '<h5 class="card-title" style="font-size:20px; color:1D2856;">' +
                            trainer.firstName +
                            " " +
                            trainer.lastName +
                            "</h5>" +
                            '<p class="card-text lead email" style="font-size:20px; color:grey;">' +
                            trainer.email +
                            "</p>" +
                            '<p class="card-text lead mobile" style="font-size:20px; color:grey;">' +
                            trainer.contactNo +
                            "</p>" +
                            "</div>" + // Close card-body
                            "</div>"; // Close card
                    });

                    // Update modal content
                    $(".trainerDetails").html(trainerDetails);

                    // Handle click event on trainer-card
                    $(".trainer-card").click(function () {
                        var trainerId = $(this).data("trainer-id");
                        console.log("trainerId", trainerId);
                        var trainerNameExternal = $(this)
                            .find(".card-title")
                            .text();
                        var trainerEmail = $(this).find(".email").text();
                        var trainerContact = $(this).find(".mobile").text();

                        $("#externalTrainerId").val(trainerId);
                        $("#trainerNameExternal").val(trainerNameExternal);
                        $("#trainerEmail").val(trainerEmail);
                        $("#trainerContact").val(trainerContact);

                        // Close the modal
                        $("#trainerMaster").modal("hide");
                    });

                    // Show the modal
                    $("#trainerMaster").modal("show");
                } else {
                    $(".trainerDetails").html(
                        "<p>Trainer details not found.</p>"
                    );
                    $("#trainerMaster").modal("show");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching trainer details:", error);
                $(".trainerDetails").html(
                    "<p>Error fetching trainer details.</p>"
                );
                $("#trainerMaster").modal("show");
            },
        });
    }

    // Trigger the function when the button is clicked
    $("button[data-bs-target='#trainerMaster']").click(function () {
        showTrainerData();
    });
});
