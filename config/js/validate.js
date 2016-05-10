  var validate = {
    config : {
      returnValue: null ,
      typeReturn : 'alert' ,
      messageId : 'mensagemFinal' ,
      imgTypes: ['jpg','png','gif'] ,
      docTypes: ['pdf','doc','docx','xls','xlsx'] ,
      fileTypes: [] ,
      maxLength : 200 ,
      progress : [] ,
      regExp: {
        email : /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i ,
      }
    },
    type : {
      text : function ( element ){
        validate.actions.reset();
        validate.config.returnValue = ( ( element.value.length <= validate.config.maxLength )  && ( element.value.length > 0 ) ) ? true : false;
        return validate.actions.message( validate.config.returnValue , element  );
      },
      file : function( element ){
        validate.actions.reset();
        var validateType = element.dataset.validate;
        var extension = element.value.split(".").pop();
        switch( validateType ){
          case 'image':
          validateType = validate.config.imgTypes;
          break;
          case 'docs':
          case 'doc' :
          validateType = validate.config.docTypes;
          break;
          default:
          validateType = validate.config.fileTypes;
        }
        for (var i = 0; i < validateType.length; i++) {
          if ( extension == validateType[i] ) {
            validate.config.returnValue = true;
            break;
          }
        }
        return validate.actions.message( validate.config.returnValue , element );
      },
      email : function( element ){
        validate.config.returnValue =  validate.config.regExp.email.test( element.value );
        return validate.actions.message( validate.config.returnValue , element );
      }
    },
    actions : {
      message : function( returnValue , element = '' ){
        if ( !returnValue ){
          if ( !element ) {
           message = "Por favor, preencha corretamente todos os campos";
         }
         else{
          validate.config.progress[ element.title ] = returnValue;   
          message = "Por favor, preencha corretamente o campo " + element.title;
          element.value = "";
          element.focus();
        }
      } 
      else {
        validate.config.progress[ element.title ] = returnValue;
        message = "";
      }
      switch( validate.config.typeReturn ){
        case 'message':
        paragraph = document.getElementById( validate.config.messageId );
        paragraph.innerHTML = message;
        paragraph.setAttribute( 'class' , returnValue );
        break;
        default:
        ( !message ) ? undefined : alert( message );
      }     
      return returnValue;
    } ,
    final : function(){
      validate.config.returnValue = true;
      for( key in validate.config.progress ){
        if ( !validate.config.progress[ key ] ) {
          validate.config.returnValue = false;
        }
      }
      return ( !validate.config.returnValue ) ? validate.actions.message ( validate.config.returnValue ) : true;
    },
    reset : function(){
      validate.config.returnValue = null;
      validate.config.fileTypes = [];
      validate.config.fileTypes = validate.config.fileTypes.concat( validate.config.imgTypes , validate.config.docTypes );
    }
  }
}