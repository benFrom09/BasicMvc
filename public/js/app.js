document.addEventListener("DOMContentLoaded", e => {
  (function() {
    function S(value) {
      return document.querySelector(value);
    }

    //burger menu

    const $navBurger = Array.prototype.slice.call(
      document.querySelectorAll(".navbar-burger"),
      0
    );
    console.log($navBurger.length);
    if ($navBurger.length > 0) {
      $navBurger.forEach(element => {
        element.addEventListener("click", e => {
          const target = element.dataset.target;
          const $target = document.querySelector(`#${target}`);
          console.log(target);
          element.classList.toggle("is-active");
          $target.classList.toggle("is-active");
        });
      });
    }

    function inputSetStyle(input, valid = true) {
      if (valid) {
        input.style.borderColor = "rgb(0, 209, 178)";
        input.style.boxShadow = "0 0 0 0.125em rgba(27, 214, 5, 0.12)";
        if (input.nextElementSibling.nextElementSibling) {
          input.nextElementSibling.nextElementSibling.firstElementChild.style.color =
            "rgb(0, 209, 178)";
        }
      } else {
        input.style.borderColor = "rgb(243, 68, 1)";
        input.style.boxShadow = "rgba(214, 5, 5, 0.12) 0px 0px 0px 0.125em";
        if (input.nextElementSibling.nextElementSibling) {
          input.nextElementSibling.nextElementSibling.firstElementChild.style.color =
            "rgb(243, 68, 1)";
        }
      }
    }

    //register form check
    sum = 0;
    if (document.querySelector("#register-submit")) {
      let $username = S("#username");
      let $email = S("#email");
      let $pass = S("#pwd");
      let $passwordConfirmation = S("#pwd-confirm");
      let $submitBtn = S("#register-submit");
      $submitBtn.disabled = true;
      let validator = new FormValidator(
        document.querySelector("#register-form")
      );

      function unlockSubmit() {
        if (
          validator.isValid("email", $email) &&
          validator.isValid("username", $username) &&
          validator.isValid("password", $pass) &&
          $passwordConfirmation.value === $pass.value
        ) {
          $submitBtn.disabled = false;
          return;
        } else {
          $submitBtn.disabled = true;
          return;
        }
      }

      $email.addEventListener("keyup", e => {
        if (validator.isValid("email", $email)) {
          inputSetStyle($email, true);
          unlockSubmit();
        } else {
          inputSetStyle($email, false);
          unlockSubmit();
        }
      });
      $username.addEventListener("keyup", e => {
        if (validator.isValid("username", $username)) {
          inputSetStyle($username, true);
          unlockSubmit();
        } else {
          inputSetStyle($username, false);
          unlockSubmit();
        }
      });

      $pass.addEventListener("keyup", e => {
        if (validator.isValid("password", $pass)) {
          inputSetStyle($pass, true);
          unlockSubmit();
        } else {
          inputSetStyle($pass, false);
          unlockSubmit();
        }
      });

      $passwordConfirmation.addEventListener("keyup", e => {
        if ($passwordConfirmation.value === $pass.value) {
          inputSetStyle($passwordConfirmation, true);
          unlockSubmit();
        } else {
          inputSetStyle($passwordConfirmation, false);
          unlockSubmit();
        }
      });
    }
  })();
});
