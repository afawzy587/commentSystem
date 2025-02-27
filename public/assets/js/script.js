document.addEventListener('DOMContentLoaded', function () {
    const replyFormPopup = document.getElementById('replyFormPopup');
    const replyForm = document.getElementById('replyForm');
    const commentIdInput = document.getElementById('commentId');
    const closeReplyFormBtn = document.getElementById('closeReplyForm');

    // Function to handle "Reply" button clicks
    function handleReplyClick(e) {
        e.preventDefault();
        const lineNumber = this.getAttribute('data-line-number');
        const commentId = this.id; // Ensure this is the correct ID
        commentIdInput.value = commentId;
        commentIdInput.lineNumber = lineNumber;
        replyFormPopup.style.display = 'flex';
    }

    // Function to attach event listeners to "Reply" buttons
    function attachReplyListeners() {
        const replyLinks = document.querySelectorAll('.add_reply');
        replyLinks.forEach(link => {
            link.removeEventListener('click', handleReplyClick); // Remove existing listeners to avoid duplicates
            link.addEventListener('click', handleReplyClick); // Attach new listener
        });
    }

    // Attach event listeners to existing "Reply" buttons on page load
    attachReplyListeners();

    // Close the pop-up form when the "Close" button is clicked
    closeReplyFormBtn.addEventListener('click', function () {
        replyFormPopup.style.display = 'none';
    });

    // Handle form submission for replies
    replyForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const commentId = commentIdInput.value;
        const lineNumber = commentIdInput.lineNumber;
        const replyContent = document.getElementById('replyContent').value;
        const errorMessagesDiv = document.getElementById('errorMessages');
        errorMessagesDiv.style.display = 'none';
        errorMessagesDiv.innerHTML = '';
        fetch('/replies', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                comment_id: commentId,
                reply_text: replyContent
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === true) {
                    replyFormPopup.style.display = 'none';
                    replyForm.reset();
                    appendNewReply(data.reply, lineNumber);
                }else if (data.status === false){
                    const errors = data.errors;
                    let errorMessages = '';
                    for (const field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            errorMessages += `<p>${errors[field].join(', ')}</p>`;
                        }
                    }
                    errorMessagesDiv.innerHTML = errorMessages;
                    errorMessagesDiv.style.display = 'block'; // Show error messages
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    // Function to append a new reply
    function appendNewReply(reply, lineNumber) {
        const newReply = document.createElement('li');
        newReply.className = 'reply new-reply';

        const replyHtml = `
            <div class="post-replies">
                <p class="meta">${new Date(reply.created_at).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' })} <a href="#">${reply.user.name}</a></p>
                <p>${reply.reply_text}</p>
            </div>
        `;

        newReply.innerHTML = replyHtml;

        // Find the replies container using the data-line-number
        const repliesContainer = document.querySelector(`[id="${lineNumber}"]`);
        if (repliesContainer) {
            repliesContainer.insertBefore(newReply, repliesContainer.firstChild);
        } else {
            const commentElement = document.querySelector(`[data-line-number="${lineNumber}"]`);
            const newRepliesContainer = document.createElement('ul');
            newRepliesContainer.className = 'comments replies';
            newRepliesContainer.id = lineNumber;
            newRepliesContainer.appendChild(newReply);
            commentElement.appendChild(newRepliesContainer);
        }

        // Remove the animation class after the animation completes
        newReply.addEventListener('animationend', () => {
            newReply.classList.remove('new-reply');
        });
    }

    // Handle new comment submission
    document.getElementById('postForm').addEventListener('submit', function (event) {
        event.preventDefault();

        const commentContent = document.getElementById('postContent').value;
        const errorCommentMessages = document.getElementById('errorCommentMessages');
        errorCommentMessages.style.display = 'none';
        errorCommentMessages.innerHTML = '';

        fetch('/comments', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // For Laravel CSRF protection
            },
            body: JSON.stringify({
                comment: commentContent
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === true) {
                    // Create a new comment element
                    const newComment = document.createElement('li');
                    newComment.className = 'clearfix new-comment'; // Add the animation class

                    // Generate a unique data-line-number for the new comment
                    const lineNumber = `reply_${Date.now()}`; // Use a timestamp for uniqueness

                    const commentHtml = `
                        <div class="main-comment">
                            <p class="meta">
                                ${data.created_at}
                                 <a href="#">${data.user_name}</a>
                                <i class="pull-right">
                                    <a class="add_reply" href="#" id="${data.encryptCommentId}" data-line-number="${lineNumber}">
                                        <small>Add Reply</small>
                                    </a>
                                </i>
                            </p>
                            <p>${data.comment.comment}</p>
                             <ul class="comments replies" id="${lineNumber}">
                             </ul>
                        </div>
                    `;

                    newComment.innerHTML = commentHtml;

                    // Append the new comment to the comments list
                    const commentsList = document.querySelector('.comments');
                    commentsList.insertBefore(newComment, commentsList.firstChild);

                    // Clear the textarea
                    document.getElementById('postContent').value = '';

                    // Add animation end listener
                    newComment.addEventListener('animationend', () => {
                        newComment.classList.remove('new-comment');
                    });

                    // Attach event listener to the new "Reply" button
                    attachReplyListeners();
                }
                else if (data.status === false){
                    const errors = data.errors;
                    let errorMessages = '';
                    for (const field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            errorMessages += `<p>${errors[field].join(', ')}</p>`;
                        }
                    }
                    errorCommentMessages.innerHTML = errorMessages;
                    errorCommentMessages.style.display = 'block'; // Show error messages
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    document.getElementById('postsContainer').addEventListener('click', function(event) {
        if (event.target.closest('.pagination a')) {
            event.preventDefault(); // Prevent default link behavior
            const url = event.target.closest('.pagination a').getAttribute('href'); // Get the pagination URL

            // Fetch the new page content
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // Indicate this is an AJAX request
                }
            })
                .then(response => response.text()) // Parse the response as text
                .then(data => {
                    // Replace the current comments container with the new content
                    document.getElementById('postsContainer').innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        }
    });
});
