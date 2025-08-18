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
                return e&&e.validate().then((function(e)
                {
                    "Valid"==e?(t.goTo(t.getNewStep()),
                    KTUtil.scrollTop()):Swal.fire(
                    {
                        text:"Sorry, looks like there are some errors detected, please try again.",
                        icon:"error",
                        buttonsStyling:!1,
                        confirmButtonText:"Ok, got it!",
                        customClass:{confirmButton:"btn font-weight-bold btn-light"}
                    }).then((function()
                    {
                        KTUtil.scrollTop()
                    }))
                })),!1
            }
        })),
        i.on("changed",(function(t)
        {
            KTUtil.scrollTop()
        })),
        o.push(FormValidation.formValidation(e,
        {
            fields:
            {
                prod_id:{validators:{notEmpty:{message:"Product Name is required"}}},
                senderno:{validators:{notEmpty:{message:"Sender Number is required"}}},
                record:{validators:{notEmpty:{message:"Record is required"}}},
                repeatbystatus:{validators:{notEmpty:{message:"Repeat by Status is required"}}},
                country:{validators:{notEmpty:{message:"Country is required"}}}
            },
            plugins:
            {
                trigger:new FormValidation.plugins.Trigger,
                bootstrap:new FormValidation.plugins.Bootstrap
            }
        })),
        o.push(FormValidation.formValidation(e,
        {
            fields:
            {
                package:{validators:{notEmpty:{message:"Package details is required"}}},
                weight:{validators:{notEmpty:{message:"Package weight is required"},digits:{message:"The value added is not valid"}}},
                width:{validators:{notEmpty:{message:"Package width is required"},digits:{message:"The value added is not valid"}}},
                height:{validators:{notEmpty:{message:"Package height is required"},digits:{message:"The value added is not valid"}}},
                packagelength:{validators:{notEmpty:{message:"Package length is required"},digits:{message:"The value added is not valid"}}}
            },
            plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap}
        })),
        o.push(FormValidation.formValidation(e,
        {
            fields:
            {
                delivery:{validators:{notEmpty:{message:"Delivery type is required"}}},
                packaging:{validators:{notEmpty:{message:"Packaging type is required"}}},
                preferreddelivery:{validators:{notEmpty:{message:"Preferred delivery window is required"}}}
            },
            plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap}
        })),
        o.push(FormValidation.formValidation(e,
        {
            fields:
            {
                locaddress1:{validators:{notEmpty:{message:"Product is required"}}},
                locpostcode:{validators:{notEmpty:{message:"Sender Number is required"}}},
                loccity:{validators:{notEmpty:{message:"City is required"}}},
                locstate:{validators:{notEmpty:{message:"State is required"}}},
                loccountry:{validators:{notEmpty:{message:"Country is required"}}}
            },
            plugins:{trigger:new FormValidation.plugins.Trigger,bootstrap:new FormValidation.plugins.Bootstrap}
        }))
    }}
}();jQuery(document).ready((function(){KTWizard3.init()}));