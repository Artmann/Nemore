Are you tired of trying to explain your relations, managing indexes and having to understand complex SQL Queries?

Does your application have a serious lack of regex?

Then this library is just the right thing for you. **Nemore** is a *Data Access Layer* that can store your data, easily accessible in memory or on disk. All you have to do to use your saved data is to fetch it with a simple regex. 

It's as simple as 1, 2 and 3

    use \Nemore\DAL;

    $dal = new DAL("mydata");
    $dal->insert("employee:Harry:");
    $dal->insert(["employee:Joey:", "employee:Chris:", "employee:Tony:"], true);

    $employees = $dal->select("/employee:([a-z]+)/i");
    print_r($employees);

