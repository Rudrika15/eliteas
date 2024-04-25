$(document).ready(function () {
    function showTrainerData2() {
        $.ajax({
            url: "/get-trainer-details",
            dataType: "json",
            success: function (data) {
                if (data && data.length > 0) {
                    var trainerDetails2 = "";
                    console.log(data);
                    data.forEach(function (trainer) {
                        trainerDetails2 +=
                            '<div class="card mb-3 mr-3 text-center trainer-card" data-trainer-id="' +
                            trainer.id +
                            '">' +
                            '<div class="card-body text-center">' +
                            '<h5 class="card-title" style="font-size:20px; color:1D2856;">' +
                            trainer.firstName +
                            " " +
                            trainer.lastName +
                            "</h5>" +
                            '<p class="card-text lead email" style="font-size:20px; color:grey;">' +
                            trainer.email +
                            "</p>" +
                            '<p class="card-text lead contactNo2" style="font-size:20px; color:grey;">' +
                            trainer.contactNo +
                            "</p>" +
                            "</div>" + // Close card-body
                            "</div>"; // Close card
                    });

                    // Update modal content
                    $(".trainerDetails2").html(trainerDetails2);

                    // Handle click event on trainer-card
                    $(".trainer-card").click(function () {
                        var trainerId = $(this).data("trainer-id");
                        var trainerNameExternal2 = $(this)
                            .find(".card-title")
                            .text();
                        var trainerEmail2 = $(this)
                            .find(".email")
                            .text();
                            console.log(trainerEmail2);

                        var trainerContact2 = $(this)
                            .find(".contactNo2")
                            .text();
                            console.log(trainerContact2);

                        $("#trainerId").val(trainerId);
                        $("#trainerNameExternal2").val(trainerNameExternal2);
                        $("#trainerEmail2").val(trainerEmail2);
                        $("#trainerContact2").val(trainerContact2);

                        // Close the modal
                        $("#trainerMaster2").modal("hide");
                    });

                    // Show the modal
                    $("#trainerMaster2").modal("show");
                } else {
                    $(".trainerDetails2").html(
                        "<p>Trainer details not found.</p>"
                    );
                    $("#trainerMaster2").modal("show");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching trainer details:", error);
                $(".trainerDetails2").html(
                    "<p>Error fetching trainer details.</p>"
                );
                $("#trainerMaster").modal("show");
            },
        });
    }

    // Trigger the function when the button is clicked
    $("button[data-bs-target='#trainerMaster2']").click(function () {
        showTrainerData2();
    });
});
