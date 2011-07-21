/*****************************************
 * EVE Online Information System Project *
 * Written By: Andy Lo                   *
 * Last Modified: 2011-18-06             *
 *****************************************/

factory = new Factory();
if(factory) {
    alert("Factory object instantiated.");
    factory.setClass(XMLHttpRequest);
    alert("Factory set to: " + factory.getClass());
    factory.create();
}

xmlhttprequest = factory.create();
if(xmlhttprequest) {
    alert("XMLHttpRequest object instantiated");
}

xmlhttprequest.setSendURL("http://www.google.com");
alert("getSendURL returns:" + xmlhttprequest.getSendURL());
xmlhttprequest.setSendMethod("GET");
alert("getSendMethod returns: " + xmlhttprequest.getSendMethod());
xmlhttprequest.setSendParameters("?action=EAT_CAKE");
alert("getSendParameters returns: " + xmlhttprequest.getSendParameters());