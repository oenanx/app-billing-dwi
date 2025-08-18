"use strict";
var KTWizard3=function()
{
    var t,e,i,o=[];
    return{init:function()
    {
        t=KTUtil.getById("kt_wizard"),
        e=KTUtil.getById("kt_form"),
        (i=new KTWizard(t,{startStep:1,clickableSteps:!0})).on("change",(function(t)
        {
            if(!(t.getStep()>t.getNewStep()))
            {
                var e=o[t.getStep()-1];
            }
        })),
        o.push(FormValidation.formValidation(e,
        {
            fields:
            {
                record:{validators:{notEmpty:{message:"Record is required"}}},
                locpostcode:{validators:{notEmpty:{message:"Sender Number is required"}}},
                loccity:{validators:{notEmpty:{message:"City is required"}}},
                locstate:{validators:{notEmpty:{message:"State is required"}}},
                loccountry:{validators:{notEmpty:{message:"Country is required"}}}
            },
            plugins:
			{
				trigger:new FormValidation.plugins.Trigger,
				bootstrap:new FormValidation.plugins.Bootstrap
			}
        }))
    }}
}();jQuery(document).ready((function(){KTWizard3.init()}));