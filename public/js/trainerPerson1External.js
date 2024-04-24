$(document).ready(function () {
    showExternalTrainerList();

    $(document).on("click", ".circle-card", function () {
        $(".circle-card").removeClass("active");
        $(this).addClass("active");
    });
});

function showExternalTrainerList() {
    $.ajax({
        url: "/get-external-trainer",
        dataType: "json",
        success: function (data) {
            if (data.length > 0) {
                var trainerList =
                    '<div class="row row-cols-1 row-cols-md-4 g-4">';
                data.forEach(function (member) {
                    var memberId = member.userId;
                    var profilePhotoUrl =
                        "../ProfilePhoto/" + member.profilePhoto;
                    trainerList += createTrainerCard(
                        memberId,
                        member,
                        profilePhotoUrl
                    );
                });
                trainerList += "</div>";
                $(".externalTrainerList").html(trainerList);
                addMemberCardClickEvent();
            } else {
                $(".externalTrainerList").html("<p>No trainers found.</p>");
            }
        },
    });
}

function createTrainerCard(userId, trainer) {
    var trainerCard =
        '<div class="col"><div id="' +
        userId +
        '" class="card h-90 member-card" data-trainer-id="' +
        trainer.userId +
        '"><div class="d-flex align-items-center justify-content-center bg-light rounded-circle mx-auto" style="width: 100px; height: 90px;"><img src="' +
        (trainer.firstName && trainer.lastName
            ? trainer.firstName + " " + trainer.lastName
            : "Trainer") +
        '" style="width: 80px; height: 80px;"></div><div class="card-body text-center"><h5 class="card-title">' +
        (trainer.firstName ? trainer.firstName + " " : "") +
        (trainer.lastName ? trainer.lastName : "") +
        '</h5><p class="card-text email">' +
        (trainer.user && trainer.user.email ? trainer.user.email : "-") +
        '</p><p class="card-text mobile">' +
        (trainer.contact && trainer.contactNo ? trainer.contactNo : "-");
    return trainerCard;
}

function addMemberCardClickEvent() {
    $(".member-card").click(function () {
        var trainerId = $(this).data("trainer-id");
        var trainerName = $(this).find(".card-title").text();
        var trainerEmail = $(this).find(".email").text();
        var trainerContact = $(this).find(".contactNo").text();

        $("#trainerId").val(trainerId);
        $("#trainerName").val(trainerName);
        $("#trainerEmail").val(trainerEmail);
        $("#trainerContact").val(trainerContact);

        console.log("trainerId", $("#trainerName").val());
        console.log("trainerName", trainerName);

        $("#trainerMaster").modal("hide");
    });
}
