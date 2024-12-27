$(document).ready(function () {
    // Function to fetch and display circle members
    function showcircleContactMembers(circleId) {
        $.ajax({
            url: "/get-circle-members?circleId=" + circleId,
            dataType: 'json',
            success: function (data) {
                if (data.length > 0) {
                    // Display circle members in the designated area
                    var membersList = '<div class="row row-cols-1 row-cols-md-4 g-4">';
                    data.forEach(function (member) {
                        // Create a unique ID for each member card
                        var memberId = member.userId;
                        // console.log("profile", member.profilePhoto);
                        var profilePhotoUrl = "../ProfilePhoto/" + member.profilePhoto;

                        // Construct the HTML for the member card
                        membersList += '<div class="col">';
                        membersList += '<div id="' + memberId + '" class="card h-90 member-contact-card" data-member-id="' + member.userId + '">';
                        membersList += '<div class="d-flex align-items-center justify-content-center bg-light rounded-circle mx-auto" style="width: 100px; height: 90px;">';
                        membersList += '<img src="' + profilePhotoUrl + '" class="card-img-top rounded-circle" alt="' + (member.firstName && member.lastName ? member.firstName + ' ' + member.lastName : 'Member') + '" style="width: 80px; height: 80px;">';
                        membersList += '</div>';
                        membersList += '<div class="card-body text-center">';
                        membersList += '<h5 class="card-title">' + (member.title ? member.title + ' ' : '') + (member.firstName ? member.firstName + ' ' : '') + (member.lastName ? member.lastName : '') + '</h5>';
                        membersList += '<p class="card-text email">' + (member.user && member.user.email ? member.user.email : '-') + '</p>';
                        membersList += '<p class="card-text mobile">' + (member.contact && member.contact.mobileNo ? member.contact.mobileNo : '-') + '</p>';
                        membersList += '<hr>';
                        membersList += '<p class="card-text">' + (member.companyName ? member.companyName : '-') + '</p>';
                        membersList += '</div></div></div>';
                    });
                    membersList += '</div>';
                    $('.circleContactMembers').html(membersList);
                    // console.log("memberList", data);
                    // Event listener for member card click
                    $('.member-contact-card').click(function () {
                        var memberId = $(this).data('member-id');
                        var memberName = $(this).find('.card-title').text();
                        var memberEmail = $(this).find('.email').text();
                        var memberContact = $(this).find('.mobile').text();



                        $('#contactPersonId').val(memberId);
                        $('#contactPersonName').val(memberName);
                        $('#contactPersonEmail').val(memberEmail);
                        $('#contactPersonContact').val(memberContact);


                        // Close the modal
                        $('#circleContactPerson').modal('hide');

                    });
                } else {
                    $('#circleContactMembers').html('<p>No members found.</p>');
                }
            }
        });
    }


    // Function to fetch and display user's circles
    function showUserCircles() {
        $.ajax({
            url: "/get-circle",
            dataType: 'json',
            success: function (data) {
                var circles = data.circles;
                var userCircleName = data.userCircleName;

                // Find the user's circle and move it to the first position in the array
                var userCircle = null;
                circles.forEach(function (circle, index) {
                    if (circle.circleName === userCircleName) {
                        console.log("circleMy", circle);
                        userCircle = circle;
                        circles.splice(index, 1); // Remove the user's circle from the array
                    }
                });
                if (userCircle) {
                    // Add the 'active' class directly to the user's circle card
                    userCircle.isActive = true;
                    circles.unshift(userCircle); // Add the user's circle to the beginning of the array
                }

                // Populate cards with circle data
                var circleMemberCards = '';
                circles.forEach(function (circle) {
                    var initial = circle.circleName.charAt(0).toUpperCase(); // Get the first character and capitalize it
                    var isActive = circle.isActive ? 'active' : ''; // Check if the circle is the user's circle

                    circleMemberCards += '<div class="col-md-3" style="cursor: pointer">';
                    circleMemberCards += '<div class="border p-2 text-center circle-contact-card ' + isActive + '" data-circle-id="' + circle.id + '">';
                    circleMemberCards += '<div class=" mb-3">';
                    circleMemberCards += '<div class="circle-image">' + initial + '</div>'; // Placeholder image using first initial
                    circleMemberCards += '<h5 class="text-center">' + circle.circleName + '</h5>';
                    circleMemberCards += '</div></div></div>';
                });
                $('.circleContactCards').html(circleMemberCards);


                $('.circle-contact-card').click(function () {
                    var circleId = $(this).data('circle-id');

                    showcircleContactMembers(circleId);
                });


                if (userCircle) {
                    showcircleContactMembers(userCircle.id);
                }
            }
        });
    }

    // Call the function to show user's circles when the page loads
    showUserCircles();

    $(document).on('click', '.circle-contact-card', function () {
        // Remove 'active' class from all circle cards
        $('.circle-contact-card').removeClass('active');
        // Add 'active' class to the clicked circle card
        $(this).addClass('active');
    });
});