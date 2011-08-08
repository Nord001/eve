/*****************************************
 * EVE Online Information System Project *
 * Written By: Andy Lo                   *
 *****************************************/

var setClassSingleton = Factory;
var setClassFactory = XMLHttpRequest;

// Instantiate Singleton object.
if(singleton = new Singleton()) {
    alert(singleton.s_name + " object instantiated.");
} else {
    alert("Failed to instantiate object.");
}

// Set the class to become a singleton.
if(singleton.setClass(setClassSingleton)) {
    alert(singleton.s_name + " set to " + setClassSingleton + ".");
} else {
    alert("Failed to set class for " + singleton.s_name + ".");
}

// Retrieve the instance of the singleton.
if(singletonInstance = singleton.getInstance()) {
    alert(singletonInstance.s_name + " object instantiated.");
}

// If the singleton is a factory, test the factory.
if(singletonInstance.s_name == 'Factory') {
    if(singletonInstance.setClass(setClassFactory)) {
        alert(singletonInstance.s_name + " set to " +
            setClassFactory + ".");
    }
    
    // Manufacture an object.
    if(factoryObject = singletonInstance.create()) {
        alert(factoryObject.s_name + " object instantiated.");
    }
    
    // If the manufactured object is an XMLHttpRequest object, test it.
    if(factoryObject.s_name == 'XMLHttpRequest') {
        factoryObject.setSendURL("http://www.google.com/search");
        alert("getSendURL returns:" + xmlhttprequest.getSendURL());
        
        factoryObject.setSendMethod("GET");
        alert("getSendMethod returns: " + xmlhttprequest.getSendMethod());
        
        factoryObject.setSendParameters("?q=the+cake+is+a+lie");
        alert("getSendParameters returns: " + xmlhttprequest.getSendParameters());    
    }
}

// Testing that the singleton does indeed keep a single instance.
if(wrongSingleton = new Singleton()) {
    alert("Created another Singleton object.");
}

if(wrongSingleton.getInstance() == setClassSingleton) {
    alert("The new Singleton object is returning the proper object");
}
