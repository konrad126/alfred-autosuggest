
Usage:

In concrete implementation of `Autosuggest` you need to implement abstract methods with concrete implementations for the site your are implementing the autosuggest workflow.
Than you can use the concrete Autosuggest implementation as follows:

```
$autosuggest = new ConcreteAutosuggestImplementation();
echo $retrieveSuggestions = $autosuggest->retrieveSuggestions("searchTerm");
```
 
 
