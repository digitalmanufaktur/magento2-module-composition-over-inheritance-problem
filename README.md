# Overview
**DMC_Composition** - the tiny library which trying to resolve the well known "composition over inheritance" problem.

# Requirements
Currently this library was tested with Magento Open Source 2.2.x but in theory could be compatible with any Magento 2.x version and with any PHP version declared along the whole Magento 2 line.

# Features
Using this library you can avoid copying of a huge constructor from a parent class or a constructor which has undesired dependencies like the Context class.

The solution is simple: put the class dependencies into the class-satellite and be independent from the parent class dependencies.

# Overview
This library consists from the two important traits. Each trait has its own implementation of the "__get" magic call. The main purpose of each trait:
- _DMC\Composition\Composite_: start from the current class and iterate through the chain of parent classes (if needed) trying to find a composition class. As soon as the composition class was founded try to instantiate it and access the requested property;
- _DMC\Composition\Composition_: share properties only for the composite class and deny access for any other class declared out of the current classes chain.

# Usage
Lets assume you want to create the class A which should extend the class B.

Also we will need the Composition class - lets name it C.

Follow these instructions:
- Required:
  - declare the class A and extend it from the class B;
  - use the Composite trait in the class A;
  - create the satellite class C in the same folder where the class A locates and name it like the original A class plus the Composition suffix at the end (for example: ProductComposition.php);
  - inside the Composition C class use the Composition trait;
  - declare constructor and properties;
- Preferred:
  - the C class should be declared as final;
  - each property of the C class should be private;
  - the C class should not contain any additional method (logic) inside it.

Now you can access properties of the Composition C class from the A class as usually (for example: $this->productProperty);

# Important
The approach developed in the library and described in this document has its own specific features:
- you need to check existence of the magic "__get" method in the class A (but very often it is not used at all) and its implementation to be sure that it is not conflicting with the one which was implemented in the Composite trait; you can call the parent "__get" method by declaring the "_get" method in the A class and by calling the parent "__get" method from it or providing your own logic inside it;
- following the ObjectManager logic the C class is always shared (it will be instantiated using the "get" method of the ObjectManager); if the shared nature of the Composition class conflicts with your current class implementation please consider not to use this approach with your class at all;
- the "debug_backtrace" call in the Composition class is still controversial; at the same time its usage required to protect properties from the free access.

# License
Each source file included in this distribution is licensed under OSL 3.0 license.

https://opensource.org/licenses/OSL-3.0 Open Software License ("OSL") v. 3.0.

Please see LICENSE.txt for the full text of the OSL 3.0 license.
