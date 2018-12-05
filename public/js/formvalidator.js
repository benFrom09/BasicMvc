class FormValidator
{
    constructor (form) {
        this.form = new FormData(form);
        this.errors = [];
        console.log(this.form);
    }

    isValid (name,input) {
        this.form.append(name,input.value);
        let regex;
        if(input.value === '' || input.value === undefined || input.value === null) {
            //=>return error;
            this.errors.push(`Le champ ${name} est vide veuillez le remplir!`)
            
        }
        
        switch(name) {
            case 'email':
                //regular expression
                regex = /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,3}$/;
                return this.match(input.value,regex,'Veuillez entrer un email valide');
            break;
            case 'username':
            //regular expression
                regex = /^[a-zA-Z0-9_]{3,15}$/i;
                return this.match(input.value,regex,'Veuillez entrer un nom d\'utilisateur valide');
            break;
            case 'password':
            //regular expression
                regex = /^[a-zA-Z0-9_]{3,15}$/i;
                return this.match(input.value,regex,'Veuillez entrer un mot de passe valide');
            break;
            default:
                console.log('name attributes must be (email or username or password)');
            break;
        }
        return true;
    }

    match (input,regex,message = '') {
        if(input.match(regex)) {
            return true;
        }
        else {
            if(message !== '' || message !== undefined || message !== null) {
                this.errors.push(message);
                return false;
            }
            return false;
        }
    }

    AjaxValidation (url,method) {
       fetch(url,{
            method:method,
            body:this.form
       });
    }
}