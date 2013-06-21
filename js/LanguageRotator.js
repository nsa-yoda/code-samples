/**
 * Call via:
 * LanguageRotator.inject("#putLanguageHere", "#putTextHere");
 * 
 * Where #putLanguageHere indicates which element to insert
 * the text representing the language and #putTextHere 
 * indicates which element to insert the text representing
 * the phrase translated. 
 * 
 * This code does not do any translation via API calls or 
 * otherwise. As it stands it only displays multiple translations
 * of "Welcome Back".
 * 
 */

var LanguageRotator = {
    translations: [
        { "English"     : "Welcome back"           },
        { "German"      : "Willkommen zurück"      },
        { "Polish"      : "Witamy z powrotem"      },
        { "English"     : "Welcome back"           },
        { "Spanish"     : "Bienvenido de nuevo"    },
        { "Turkish"     : "Tekrar ho. geldiniz"    },
        { "Swahili"     : "Karibu tena"            },
        { "English"     : "Welcome back"           },
        { "Portuguese"  : "Bem-vindo de volta"     },
        { "Hungarian"   : "Üdvözöljük"             },
        { "Greek"       : "..... ...... ... ...."  },
        { "Filipino"    : "Maligayang pagbalik"    },
        { "English"     : "Welcome back"           },
        { "Croatian"    : "Dobrodo.li natrag"      },
        { "Belarusian"  : "........ ........."     },
        { "Bulgarian"   : "..... ..... ......."    },
        { "Czech"       : "Vítejte zp.t"           },
        { "English"     : "Welcome back"           },
        { "Finnish"     : "Tervetuloa takaisin"    },
        { "Haitian"     : "Byenveni"               },
        { "Indonesian"  : "Selamat datang kembali" },
        { "Malay"       : "Selamat kembali"        },
        { "English"     : "Welcome back"           },
        { "Romanian"    : "Bine ai revenit"        },
        { "Swedish"     : "Välkommen tillbaka"     }, 
        { "Russian"     : "..... .........."       },
        { "Norwegian"   : "Velkommen tilbake"      },
        { "English"     : "Welcome back"           },
        { "Italian"     : "Bentornato"             },
        { "French"      : "Bienvenue à nouveau"    },
        { "Danish"      : "Velkommen tilbage"      },
        { "Catalan"     : "Benvingut de nou"       },
        { "English"     : "Welcome back"           },
        { "Dutch"       : "Welkom terug"           },
        { "Azerbaijani" : "Xo. g.lmisiniz"         }
    ],
    select: function(){
        return this.translations[Math.floor((Math.random() * this.translations.length) + 1)];
    },
    inject: function(keyElement, valueElement){
        var array = this.select();
        var keyElementPointer = $(keyElement);
        var valueElementPointer = $(valueElement);
        for(var key in array){
            if(valueElementPointer.length > 0)
                valueElementPointer.text(array[key]); 
            if(keyElementPointer.length > 0)
                keyElementPointer.text("(" + key + ")");
        }
    }
}