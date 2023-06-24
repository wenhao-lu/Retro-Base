import $ from "jquery";

class MyNotes {
  constructor() {
    this.events();
  }

  events() {
    $(".delete-note").on("click", this.deleteNote);
    $(".edit-note").on("click", this.editNote);
    $(".update-note").on("click", this.updateNote.bind(this));
    $(".submit-note").on("click", this.createNote.bind(this));
  }

  // CRUD -> Create a new Note
  createNote(e) {
    // get the input value of the note field
    var newNote = {
      title: $(".new-note-title").val(),
      content: $(".new-note-body").val(),
      //status: "craft/private", post status in the CMS
      status: "publish",
    };
    // POST request
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", siteData.nonce);
      },
      url: siteData.root_url + "/wp-json/wp/v2/note/",
      type: "POST",
      data: newNote,
      success: (response) => {
        // add new notes below, and give the same style from page-notes.php
        $(".new-note-title, .new-note-body").val("");
        $(`
          <li data-id="${response.id}">
            <input readonly class="note-title-field" value="${response.title.raw}">
            <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
            <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
            <textarea readonly class="note-body-field">${response.content.raw}</textarea>
            <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
          </li>
          `)
          .prependTo("#my-notes")
          .hide()
          .slideDown();

        console.log("Http Request Success");
        console.log(response);
      },
      error: (response) => {
        if (response.responseText == "You have reached your note limit.") {
          $(".note-limit-message").addClass("active");
        }
        console.log("Http Request fail");
        console.log(response);
      },
    });
  }

  // CRUD -> Edit Note
  editNote = (e) => {
    // target this note
    var thisNote = $(e.target).parents("li");
    if (thisNote.data("state") == "editable") {
      this.noteReadonly(thisNote);
    } else {
      this.noteEditable(thisNote);
    }
  };

  noteEditable(thisNote) {
    thisNote
      .find(".edit-note")
      .html('<i class="fa fa-times" aria-hidden="true"></i> Cancel');
    thisNote
      .find(".note-title-field, .note-body-field")
      .removeAttr("readonly")
      .addClass("note-active-field");
    thisNote.find(".update-note").addClass("update-note--visible");
    thisNote.data("state", "editable");
  }

  noteReadonly(thisNote) {
    thisNote
      .find(".edit-note")
      .html('<i class="fa fa-pencil" aria-hidden="true"></i> Edit');
    thisNote
      .find(".note-title-field, .note-body-field")
      .attr("readonly", "readonly")
      .removeClass("note-active-field");
    thisNote.find(".update-note").removeClass("update-note--visible");
    thisNote.data("state", "cancel");
  }

  // CRUD -> Delete note
  // WP-Nonce, need this authorization to access the WP data
  deleteNote(e) {
    // target this note
    var thisNote = $(e.target).parents("li");

    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", siteData.nonce);
      },
      url: siteData.root_url + "/wp-json/wp/v2/note/" + thisNote.data("id"),
      type: "DELETE",
      success: (response) => {
        thisNote.slideUp();
        console.log("Http Request Success");
        console.log(response);
        if (response.userNoteCount < 5) {
          $(".note-limit-message").removeClass("active");
        }
      },
      error: (response) => {
        console.log("Http Request fail");
        console.log(response);
      },
    });
  }

  // CRUD -> Update note
  // POST request
  updateNote(e) {
    var thisNote = $(e.target).parents("li");
    // get the input value of the note field
    var updatedNote = {
      title: thisNote.find(".note-title-field").val(),
      content: thisNote.find(".note-body-field").val(),
    };
    // Http POST request to WP database
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", siteData.nonce);
      },
      url: siteData.root_url + "/wp-json/wp/v2/note/" + thisNote.data("id"),
      type: "POST",
      data: updatedNote,
      success: (response) => {
        this.noteReadonly(thisNote);
        console.log("Http Request Success");
        console.log(response);
      },
      error: (response) => {
        console.log("Http Request fail");
        console.log(response);
      },
    });
  }
}

export default MyNotes;
