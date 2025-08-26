<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

class TermsConaditions extends Component
{
    public $data = [];

    public function mount(){
        $this->data = [
            "Introduction" => 'Welcome to Armoury Broker, operated by Armoury Broker (Pty) Ltd (Registration Number: 2024/762433/07). These Terms of Use govern your access to and use of our cloud-based multi-vendor marketplace platform, services, applications and tools (collectively "Services").',
            "About Armoury Broker" => "Armoury Broker is a cloud-based multi-vendor marketplace that addresses market inefficiency by establishing a formalized platform for armoury-related equipment. The system facilitates peer-to-peer transactions—buying, selling, trading, raffling, and auctioning—of weapons, tactical equipment, peripherals and non-firearm merchandise within a secure framework. Built on principles of trust and security, the platform delivers end-to-end transaction management, including escrow-based payments and comprehensive buyer-seller protection.<br />Operating as a structured marketplace, Armoury Broker responds to the growing demand for both new and used armoury equipment while creating value through enhanced trust, regulatory compliance, and improved market efficiency. The platform provides a legitimate channel for South Africa's firearms and tactical equipment community while enabling better oversight and security of high-value transactions.",
            "Agreement to Terms" => [
                'All policies and guidelines are incorporated into these Terms of Use. By accessing or using our Services, you agree to comply with all applicable terms and conditions.',
                'Should you not agree to these terms, or any updates or changes thereto as outlined below, you must not access or use Armoury Broker.',
                'By continuing to use our Services, you confirm that you are either 18 years of age or older or possess the necessary legal consents to agree to these terms.',
                '<b>Firearms Control Act 60 of 2000 Compliance:</b> Users acknowledge that all regulated item(s) transactions must comply with the Firearms Control Act 60 of 2000, including any applicable amendments to the act and related regulations. Users warrant that they hold all necessary licenses and permits required by law.<br /><b>Effective Date: 01 July 2025</b>',
            ],
            "User Responsibility and Platform Management" => [
                'You are solely responsible for all information that you submit to the Armoury Broker platform and any consequences that may result from your listings or interactions.',
                'We reserve the right, for any or no reason, at our sole discretion to refuse, delete, or take-down content (or any part thereof) that we believe is inappropriate, breaches these terms, or violates applicable laws and regulations.',
                'We may, at our discretion, remove listings, suspend transactions, put listings on hold, or make necessary modifications when they do not comply with our rules, applicable laws, or platform standards.',
                "We reserve the right at our sole discretion to restrict a user's access to the platform either temporarily or permanently, suspend user accounts, or refuse user registration or re-registration.",
                'Given the nature of armoury-related transactions, we maintain enhanced monitoring and may implement additional verification procedures to ensure compliance with all applicable firearms and consumer protection legislation.',
            ],
            "Prohibited User Activities" => [
                "As a condition of your use of the Armoury Broker platform, you agree that you will not:",
                "Violate any applicable laws including but not limited to consumer protection, data protection, firearms legislation, and intellectual property laws;",
                "Violate any applicable posting rules or platform guidelines;",
                "Post listings that do not show clear, truthful, verifiable, complete and unambiguous information regarding your contact details, the goods, price, delivery and any additional charges;",
                "Post any threatening, abusive, defamatory, pornographic, obscene, unconstitutional or indecent material;",
                "Use the Services in any manner that could impair our platform, website or applications, or interfere with any party's use or enjoyment of the Armoury Broker platform;",
                "Be false or misleading in your listings or employ false or misleading advertising practices;",
                "Infringe any third-party right, including but not limited to intellectual property, privacy, or publicity rights;",
                "Distribute or contain spam, chain letters, or pyramid schemes;",
                "Distribute viruses or any other technologies that may harm Armoury Broker or the interests or property of Armoury Broker users;",
                "Impose an unreasonable load on our infrastructure or interfere with the proper working of the Armoury Broker platform;",
                "Copy, modify, or distribute any other person's content without their express consent;",
                "Use any robot, spider, scraper or other automated means to access Armoury Broker and collect content for any purpose without our express written permission;",
                "Harvest or otherwise collect information about others, including email addresses, without their consent or otherwise violate the privacy of another person;",
                "Use the information available on Armoury Broker to contact users or advertisers for any purpose other than legitimate use of our Services;",
                "Bypass measures used to prevent or restrict access to the Armoury Broker platform;",
                "Attempt to circumvent our escrow services, payment processing, or security measures;",
                "Engage in transactions outside of the platform's secure framework after initial contact through Armoury Broker.",
            ],
            "Platform Functionality and Transaction Process" => [
                "Platform Features <br />The Armoury Broker platform allows:" => [
                    "Opening a web store on the platform", 
                    "Selling armoury-related goods, weapons, tactical equipment, peripherals and non-firearm merchandise on the platform with flexible delivery options and dealer stocking ",
                    "Browsing, saving to favourites, and buying products from other users",
                    "Communicating with other platform users through private messages", 
                    "Sharing advertisements of goods being sold on the platform on various social media channels",
                ],
                "Escrow and Payment Services" => [
                    "Armoury Broker provides secure funds deposit services for the performance of sales contracts concluded by users.",
                    "When making a purchase, the buyer transfers the purchase price, inclusive of all applicable platform and delivery charges to Armoury Broker through available payment methods including traditional EFT, Instant EFT, debit / credit cards, or any other payment options available on the platform.",
                ],
                "Payment Agent Appointment" => [
                    "The seller hereby appoints Armoury Broker (Pty) Ltd to act on its behalf as its limited payment agent to accept payment on its behalf for goods sold through the platform.",
                ],
                "Currency" => [
                    "All purchase and sales transactions on the platform must be conducted in South African Rands.",
                ],
                "Purchase and Sale Process" => [
                    "The transaction process operates as follows:<br /><br />".
                    "<b>Step 1: Purchase Initiation</b> The buyer finds a product of interest on the platform and makes payment through one of the available payment options on the platform.<br /><br />".
                    "<b>Step 2: Payment Processing</b> The purchase price, inclusive of all applicable platform and delivery charges is transferred to Armoury Broker's account, acting as the seller's limited payment agent to receive payment on their behalf from the buyer.<br /><br />".
                    "<b>Step 3: Delivery Method Selection and Payment</b> The buyer selects their preferred delivery option from what the seller has made available during the listing of the item. Any applicable delivery fees are added to the total purchase price unless the seller has enabled 'free delivery', 'drop off / collection', or 'dealer stocking'. For courier services, the seller must book and pay the courier separately and will be refunded once the item has been shipped and received. For dealer stocking, any dealer fees are external to the platform and paid directly by the buyer to the dealer.<br /><br />".
                    "<b>Step 4: Shipping/Delivery Confirmation</b> The seller confirms the shipping, collection, or dealer stocking of goods to the buyer via the platform by clicking the ‘Order Dispatched' button and includes a tracking number when available (for courier services).<br /><br />".
                    "<b>Step 5: Delivery Confirmation</b> The buyer confirms receipt of goods through the platform by clicking the 'Order Complete’ button and confirms in the following pop-up that they are satisfied with the goods and agree to release the purchase price to the seller's Armoury Broker wallet.<br /><br />".
                    "<b>Step 6: Payment Release</b> Armoury Broker thereafter releases the payment to the seller's Armoury Broker wallet and the sales transaction is deemed completed (unless the transaction is reported for any reason).<br /><br />".
                    "<b>Step 7: Payout Process</b> To transfer funds to the seller's bank account, the seller must initiate the payout process by clicking the ‘Release Funds’ button. Once initiated, Armoury Broker will transfer funds to the seller's bank account within 1-3 business days, subject to the accuracy and validity of the banking details provided by the seller.<br /><br />"
                ],
                "Banking Requirements" => [
                    "The seller's banking details must be from a recognised South African bank. It is the seller's responsibility to ensure that banking details provided are accurate, up-to-date and linked to a South African bank account from a recognised bank.",
                    "Armoury Broker will not be held responsible for any delays or losses incurred as a result of funds transfers to the provided account.",
                ],
                "Transaction Confirmations" => [
                    "Both buyers and sellers involved in transactions will receive notifications on the platform and via their registered email addresses for all activities that form part of the sales transaction.",
                    "Confirmation notices and emails will be sent to both parties for the following transaction milestones:<br />".
                    "<ul>".
                        "<li>Item purchase confirmation</li>".
                        "<li>Funds received confirmation</li>".
                        "<li>Item shipped notification</li>".
                        "<li>Item received confirmation</li>".
                        "<li>Funds release notification</li>".
                    "</ul>",
                    "These notifications ensure full transparency and provide both parties with a complete transaction record throughout the sales process.",
                ],
                "Delivery Options and Courier Services" => [
                    "Sellers may specify the delivery options they would like to offer for their items. The courier service value is determined based on package size and delivery requirements.",
                    "When purchasing an item, buyers select their preferred delivery option from the available list provided by the seller, which may include:".
                    "<ul>".
                        "<li>Courier services (various options as specified by the seller)</li>".
                        "<li>Collection (buyer collects directly from seller)</li>".
                        "<li>Free delivery (at seller's discretion)</li>".
                        "<li>Dealer stocking (through licensed firearm dealers)</li>".
                    "</ul>",
                    "Courier Service Payment Process: For courier services, the courier fee is added to the total purchase price. The seller must book and pay the courier service separately and will be refunded once the item has been shipped and received in good order.",
                    "Dealer Stocking: For dealer stocking arrangements, any dealer fees are external to the platform and paid directly by the buyer to the dealer. Armoury Broker requires confirmation from both buyer and seller that the item has been dealer stocked before funds are released.",
                    "Free Delivery and Collection: No additional delivery fees apply when the seller enables 'free delivery' or when 'collection' is selected as the delivery method.",
                ],
                "Payment Limitations" => [
                    "The user's right to purchase on the platform is subject to any limits Armoury Broker or our payment processors may establish.",
                    "If payment cannot be charged to the user's payment method or a charge is returned for any reason, including chargebacks, Armoury Broker reserves the right to suspend or terminate the transaction.",
                ],
            ],
            "Service Fees" => [
                "Seller Fees" => [
                    "Opening a shop, adding items to the Armoury Broker platform, and listing items for sale is free of charge.",
                    "Sellers have the flexibility to split or absorb the platform and delivery fees when listing their items.",
                ],
                "Platform Fees" => [
                    "All transactions are subject to platform fees to ensure secure transactions and comprehensive protection services.",
                    "Armoury Broker charges a platform fee to the buyer for facilitating transactions through our secure marketplace. This fee is calculated as the greater of R25 or 5% of the transaction value (including item price and applicable delivery/courier charges) and is payable by the buyer at the time of purchase (unless the seller has chosen to split or absorb this fee).",
                ],
                "Platform Fee Refund Policy" => [
                    "If an order is cancelled due to the item not having been shipped by the seller, the full amount including the platform fees will be refunded to the buyer.",
                    "If an order is cancelled in accordance with the buyer's right to return the item (as outlined in Section 13 of these Terms), the full amount including the platform fees will be refunded to the buyer.",
                    "Armoury Broker reserves the right to charge the platform fees if an order is cancelled in violation of these Terms.",
                ],
                "Payment Processing" => [
                    "We offer the following payment methods to complete your transactions:",
                    "Traditional EFT (Electronic Funds Transfer)".
                    "<ul>".
                        "<li>No additional gateway charges</li>".
                        "<li>Payment confirmation within 1-3 business days</li>".
                        "<li>Standard bank transfer processing times apply</li>".
                    "</ul>",
                    "Instant EFT (Electronic Funds Transfer)".
                    "<ul>".
                        "<li>Payment Gateway Provider charges will apply</li>".
                        "<li>Immediate payment confirmation</li>".
                        "<li>Secure bank-to-bank transfer</li>".
                    "</ul>",
                    "Credit or Debit Card Payments".
                    "<ul>".
                        "<li>Payment Gateway Provider charges will apply</li>".
                        "<li>Immediate payment confirmation</li>".
                        "<li>Accepts major credit and debit cards7.5 Fee Transparency</li>".
                    "</ul>",
                    "All applicable fees, including platform fees and payment processing charges, will be clearly displayed in your checkout cart before you confirm and complete your payment. No hidden fees or surprise charges will be applied after checkout confirmation.",
                ],
                "Complete Fee Structure Summary".
                "<ul>".
                    "<li>Seller Fees: Free to list and sell items (with option to split or absorb platform and delivery fees)</li>".
                    "<li>Buyer Fees: Purchase Price + Applicable Courier/Delivery Fees + Platform Fee + Payment processing fee (if applicable)</li>".
                    "<li>Platform Fee: Greater of R25 or 5% of transaction value (buyer pays, unless seller choses to either absorb or split)</li>".
                    "<li>Delivery Fees: Included in the total purchase price based on the selection(s) made by the seller at listing and the buyer at the purchasing stage. Refunded upon successful delivery (except for free delivery, collection, or dealer stocking)</li>".
                    "<li>Traditional EFT: Charges per your banking provider.</li>".
                    "<li>Instant EFT: Charges per the Payment Gateway provider</li>".
                    "<li>Card Payments: Charges we the Payment Gateway provider</li>".
                "</ul>",
            ],
            "Transaction Security" => [
                "Secure Transaction Environment" => [
                    "To protect the interests of all users of the Armoury Broker platform, the entire sales process must take place within the platform environment.",
                    "Buyers must use only the payment methods and delivery options available within the platform environment.",
                    "Buyers can pay for goods through one of the payment methods available on the Armoury Broker platform.",
                ],
                "Fraud Protection Framework" => [
                    "The platform protects both buyers and sellers from potential fraud through comprehensive security measures.",
                ],
                "Escrow Service Protection" => [
                    "After a purchase is made, the amount paid for goods is deposited to Armoury Broker's account until the order is completed, ensuring funds are held securely during the transaction process.",
                ],
                "Delivery Method Verification" => [
                    "The seller confirms the shipping, collection, or dealer stocking of goods by clicking the 'Item shipped' button for the respective order and providing tracking information when applicable for courier services.",
                ],
                "Delivery Confirmation Process" => [
                    "After goods have been shipped via courier, collected by the buyer, or dealer stocked, Armoury Broker will wait for the buyer to confirm receipt of the goods through the platform's confirmation system.",
                ],
                "Secure Fund Release" => [
                    "Once the buyer has confirmed receipt of goods by clicking the 'Item received' button in the corresponding order and confirmed in the following pop-up that they are satisfied with the goods and agree to release funds to the seller's Armoury Broker wallet, Armoury Broker will release the funds to the seller's wallet.",
                ],
                "Communication and Transparency" => [
                    "To enhance clarity and minimize potential disagreements between buyers and sellers, we encourage all parties to communicate with each other through the platform's messaging system.",
                    "Prior to purchase, it is recommended that buyers and sellers disclose all relevant information about the goods, and that any questions or concerns are addressed in a timely manner.",
                    "Given the specialized nature of armoury-related equipment, clear communication regarding specifications, condition, compliance requirements, and any legal considerations is particularly important to ensure successful transactions and user satisfaction.",
                ]
            ],
            "Geographic Restrictions and Regulatory Compliance" => [
                "Geographic Restrictions" => [
                    "Armoury Broker facilitates transactions on the platform that take place within the Republic of South Africa.",
                    "All sellers are therefore required to provide the details of a valid South African bank account to receive payout payments from the platform.",
                ],
                "Regulatory Compliance" => [
                    "Armoury Broker (Pty) Ltd and its payment service providers are compliant with all applicable Anti-Money Laundering and Counter-Terrorism Financing ('AML/CTF') regulations including the Financial Intelligence Centre Act 38 of 2001 ('FICA').",
                    "A user's ability to make use of the platform may therefore be regulated by such laws and the respective rules and regulations.",
                ],
                "Verification Requirements" => [
                    "Armoury Broker may, at various times and depending on a range of factors in its sole discretion, require that a user submit certain information to Armoury Broker and/or its authorized third-party service providers for verification purposes.",
                    "This information may include identity documents, passport documents, firearms licenses, and/or bank account information.",
                    "Given the nature of armoury-related transactions, additional verification requirements may apply to ensure compliance with firearms legislation and related regulatory frameworks.",
                ],
                "Payment Withholding Rights" => [
                    "Armoury Broker reserves the right to withhold any payment and limit or terminate a user's access and use of the platform should the user fail to adhere to these requirements.",
                    "Armoury Broker also reserves the right to share this information with any legal authority when required under applicable laws.",
                ],
            ],
            "Shipping and Timeline Requirements" => [
                "Seller Delivery Obligations" => [
                    "The seller is expected to process the delivery of an item as soon as possible and always within 7 (seven) calendar days from the date of purchase confirmation, unless otherwise agreed upon between the buyer and seller through the platform's messaging system.",
                    "To confirm the delivery method execution, the seller must click the 'Item shipped' button for the respective order and provide tracking information when available for courier services.",
                    "For courier services, the seller must ensure the item is handed over to the selected courier service within the specified timeframe.",
                    "For collection arrangements, the seller must make the item available for collection and coordinate with the buyer.",
                    "For dealer stocking, the seller must deliver the item to the designated licensed dealer within the specified timeframe.",
                    "Given the specialized nature of armoury-related equipment and potential regulatory requirements, sellers should factor in any necessary compliance checks or documentation requirements when determining delivery timelines.",
                ],
                "Buyer Receipt Confirmation" => [
                    "The buyer has up to 48 (forty-eight) hours after collecting or receiving the goods to confirm receipt through the platform or submit a claim (as outlined in Section 13 of these Terms).",
                    "To confirm receipt of goods, the buyer must click the 'Item received' button for the respective order and confirm in the following pop-up that they are satisfied with the goods and agree to release the funds to the seller's Armoury Broker wallet.",
                    "If the buyer has not confirmed receipt of goods or submitted a claim within 48 (forty-eight) hours after collecting the goods, Armoury Broker reserves the right to complete the order on the buyer's behalf.",
                    "Armoury Broker will verify the tracking information provided by the seller, and if this information is sufficient for completing the order, we will release the funds to the seller's Armoury Broker wallet.",
                    "If the tracking information is insufficient or unclear about delivery, Armoury Broker will contact the buyer via their registered email address and request confirmation of receipt or submission of a claim within 48 (forty-eight) hours.",
                    "If the buyer does not respond within the specified 48-hour period, the goods are considered as received and Armoury Broker will complete the order accordingly.",
                ],
                "Payment Release Process" => [
                    "Armoury Broker will release the payment made by the buyer to the seller's Armoury Broker wallet following confirmation from the buyer of receipt of goods and their satisfaction with the transaction.",
                    "Once funds are in the seller's Armoury Broker wallet, the seller can choose between using the funds for future purchases on the platform or requesting a payout to their chosen South African bank account.",
                ],
                "Payout Procedures" => [
                    "The seller can initiate a payout to their bank account by clicking the 'Payout to bank account' button within their account dashboard.",
                    "Banking details must be entered and maintained in the Settings section of the seller's account on the platform.",
                    "It is the seller's responsibility to ensure that banking details provided are accurate, up-to-date, and linked to a valid South African bank account from a recognized South African banking institution.",
                    "Once the seller has initiated a payout request, Armoury Broker will process the transfer of funds to the seller's designated bank account within 1-3 business days, subject to standard banking processing times.",
                ],
                "Order Cancellation Rights" => [
                    "If the seller has not processed the delivery (shipped via courier, made available for collection, or delivered to dealer) within 10 (ten) working days from the date of purchase confirmation, Armoury Broker reserves the right to cancel the order and issue a full refund to the buyer.",
                    "If an order has been in 'In-transit' status for over 10 (ten) working days without delivery confirmation, Armoury Broker reserves the right to investigate the transaction and take appropriate action.",
                ],
                "Enhanced Security Measures" => [
                    "Given the nature of armoury-related transactions, Armoury Broker may implement additional verification steps or extended processing times for high-value transactions or items requiring special handling compliance.",
                    "All parties acknowledge that certain armoury-related items may require additional documentation, verification, or compliance checks that could affect standard processing timelines.",
                ],
            ],
            "Liability Disclaimers" => [
                "Platform Role and Limitations" => [
                    "Armoury Broker is not the owner or seller of any goods sold on the platform and does not participate in sales, purchases, or other transactions that occur between users of the platform.",
                    "Sale agreements are concluded between users of the platform without the representation and mediation of Armoury Broker. Users are fully responsible for the execution of their sale agreements.",
                    "Complaints, queries, and claims regarding goods on the platform must be submitted directly to the seller by using the messaging system on the platform.",
                ],
                "Quality and Compliance Disclaimers" => [
                    "Armoury Broker does not inspect nor ensure any guarantee for the goods sold on the platform and does not review nor check the quality or suitability of the goods sold or the compliance thereof with the description entered by the seller.",
                    "Given the specialized nature of armoury-related equipment, Armoury Broker particularly disclaims any responsibility for the technical specifications, compatibility, legal compliance, or operational condition of weapons, peripherals, or related equipment listed on the platform.",
                    "Armoury Broker is not liable for the truthfulness and lawfulness of the information published by a user on the platform or for a user's inappropriate or unlawful behavior.",
                ],
                "Delivery and Transportation Disclaimers" => [
                    "Armoury Broker is not liable for damages due to improper or inadequate packaging of any goods by the seller.",
                    "Armoury Broker holds no responsibility for delays, parcel damages, or losses incurred during courier services, collection arrangements, or dealer stocking processes utilized by platform users.",
                    "All claims related to courier services must be submitted directly to the respective courier companies. Claims related to collection or dealer stocking arrangements must be resolved directly between the relevant parties.",
                    "Given the sensitive nature of armoury-related deliveries, users acknowledge that additional restrictions, licensing requirements, or regulatory compliance measures may apply to courier services, collection arrangements, and dealer stocking, for which Armoury Broker bears no responsibility.",
                ],
            ],
            "User Rights and Obligations" => [
                "Legal Capacity and Age Requirements" => [
                    "The user confirms that they are above the age of majority (18 years) and have the legal capacity to understand, agree with, and be bound by these Terms.",
                    "Where you are under the age of majority, you warrant that you have the consent of your parent or guardian to use the platform, who understands that they will be responsible for all your actions on the platform and any associated expenses.",
                    "Firearms License Requirements: Given the nature of armoury-related transactions, users must also confirm they have the legal right to purchase, sell, or possess the categories of items they intend to transact in, in accordance with the Firearms Control Act 60 of 2000 and all related legislation.",
                ],
                "Information Accuracy and Integrity" => [
                    "When using the platform, the user undertakes to provide completely correct information, including true data on the quality and condition of the goods sold, as well as other details which may affect the buyer's decision to purchase a good.",
                    "For armoury-related items, this includes but is not limited to: serial numbers (where applicable), licensing requirements, legal compliance status, modifications, defects, and any restrictions on transfer or ownership.",
                    "To use the platform, including to make sales transactions, the user undertakes to enter their valid email address to the platform and be available via email.",
                ],
                "Legal Compliance Obligations" => [
                    "The user undertakes to conduct only legal purchase and sales transactions through the platform.",
                    "The user undertakes to ensure that their activities do not violate the property rights or moral rights (including intellectual property) of any third parties.",
                    "The user undertakes to ensure that their activities comply with all applicable laws, including legislation regulating consumer protection, competition, firearms licensing, import and export of goods, and any other relevant regulatory frameworks.",
                    "Users specifically acknowledge their responsibility to comply with the Firearms Control Act 60 of 2000 and all related regulations when dealing with weapons or related equipment.",
                ],
                "Prohibited Conduct" => [
                    "The user undertakes to ensure that their actions and activities are lawful and in accordance with good practice. Users warrant that they shall not:" => [
                        "Act in a threatening, harassing, abusive, racist, sexist, or discriminatory manner;", 
                        "Promote sexually explicit material;",
                        "Act in a violent or discriminatory manner based on race, sex, religion, nationality, disability, sexual orientation, age, or any other listed ground;",
                        "Publish personal data or breach another user's privacy rights;", 
                        "Share or promote unlawful, false, or inaccurate information;", 
                        "Be impolite or undertake repressive activities in communications with other users;", 
                        "Act and use the platform in bad faith.",
                    ],
                ],
                "Item Listing Requirements" => [
                    "The user undertakes to ensure that the items uploaded to their shop are done so in accordance with the law and good practice and are not Prohibited Items (as defined in Section 14).",
                    "For armoury-related items, users must ensure all items comply with applicable licensing requirements and legal ownership standards before listing.",
                    "Firearm and Regulated Items Specific Requirements: Users listing firearms and regulated items on the platform are required to adhere to all relevant laws and regulations. Uses listing the aforementioned items must be able to present documented proof of legal ownership and full compliance with Section 9 (competency certificates), Section 13 (licenses), and Section 15 (dealer licenses where applicable) of the Firearms Control Act 60 of 2000 to Armoury Broker upon request.",
                ],
                "Image and Description Standards" => [
                    "Own Images".
                    "<ul>".
                        "<li>The user undertakes to ensure that the item description and the pictures of the item uploaded to the platform describe the item accurately.</li>".
                        "<li>The pictures uploaded should be the user's own photos of the actual item, not photos taken from the internet or other sources.</li>".
                        "<li>Images used should not be generated using AI or any other software or related application.</li>".
                        "<li>No images uploaded to the platform for an item should infringe the intellectual property of any third party.</li>".
                    "</ul>",
                    "Item Description Requirements".
                    "<ul>".
                        "<li>There should be no information in the description which does not relate to the item on sale.</li>".
                        "<li>The user must upload each item separately to the platform, under their corresponding category.</li>".
                        "<li>In the item description, the user should describe any defect, alteration, or missing part of the item.</li>".
                        "<li>Users are prohibited from uploading an item that is not available or already sold.</li>".
                        "<li>Users can only upload items which they are sure are authentic and are in no way counterfeit or grey goods.</li>".
                    "</ul>",
                ],
                "Delivery and Packaging Obligations" => [
                    "The user, in the role of a seller, undertakes to ensure that the item advertised for sale is compatible with the delivery options made available to the buyer and is safely packaged when applicable.",
                    "For courier services, the seller takes full responsibility for ensuring items are properly packaged and ready for courier collection. The seller is liable for any damage that occurs due to inadequate packaging.",
                    "For collection arrangements, the seller must ensure items are securely stored and ready for safe handover to the buyer.",
                    "For dealer stocking, the seller must ensure compliance with all dealer requirements and proper preparation for transfer to the licensed dealer.",
                    "For armoury-related items, sellers must ensure compliance with all applicable courier service policies, collection safety requirements, or dealer stocking regulations as required by law.",
                ],
                "Tax and Legal Obligations" => [
                    "The user confirms that they are aware that the obligation to declare and pay taxes (including value added tax and income tax) on all transactions lies with the user and for which Armoury Broker takes and holds no responsibility.",
                    "The user confirms that they are aware that if third parties gain access to the user's information technology equipment so that the user is logged into the platform, third parties may assume obligations that are binding to the user.",
                ],
                "Transaction Execution and Returns" => [
                    "Users are responsible for the execution of their sales agreements. Complaints and queries related to the goods sold must be submitted directly to the seller using the platform's messaging system.",
                    "When concluding a sales agreement, the seller undertakes to accept return of the goods if the buyer wishes to return the goods within 48 (forty-eight) hours from the receipt of the goods because the goods differ significantly from the description in the sales advertisement or from the photo of the product (see Section 15). Return arrangements must comply with the original delivery method used (courier service, collection, or dealer stocking).",
                ],
            ],
            "Platform Management Rights" => [
                "Platform Management and Enforcement Rights" => [
                    "Armoury Broker is justified, at its own discretion, to restrict or revoke the User's access to the platform, including changing the information published by the User on the platform, stop a sale regardless of its status, cancel a payout and refund the other party as appropriate, or close their User account and not allow them to re-register as a User if:" => [
                        "The User violates these Terms; ",
                        "The User has submitted information that is incorrect, misleading, or inaccurate when registering on the platform or using the platform;",
                        "The User knowingly and intentionally disseminates false information on Armoury Broker's platform, insults any other User in any way, or acts in bad faith;", 
                        "The purchase or sales offers entered by the User are in violation of these Terms, good practice, or applicable law, including firearms legislation;", 
                        "Armoury Broker receives at least three complaints from other Users about the User's activity;",
                        "The User attempts to conduct transactions outside of the platform's secure framework;", 
                        "The User lists or attempts to sell Prohibited Items as defined in Section 14.",
                    ],
                ],
                "Monitoring and Oversight" => [
                    "Armoury Broker is entitled to monitor all activity on the platform, including, but not limited to, purchase and sale offers, transaction communications made via the platform by Users, and compliance with firearms and related legislation.",
                    "Users understand that they have no expectation of privacy from Armoury Broker when engaging with other Users on the platform and understand that all communications must be made in accordance with these Terms and applicable laws.",
                    "Given the nature of armoury-related transactions, Armoury Broker reserves the right to implement enhanced monitoring procedures and additional verification requirements to ensure compliance with all applicable legislation and platform security standards.",
                ],
            ],
            "Prohibited Goods" => [
                "Platform Content Control" => [
                    "Armoury Broker reserves the right to determine what items are and aren't allowed to be listed on the platform.",
                    "It is strictly forbidden to upload counterfeit items to the platform.",
                    "Should we discover that any item listed on the platform violates our Terms or poses any risk to other users or the platform, Armoury Broker reserves the right to remove those items from sale.",
                ],
                "Prohibited Items List" => [
                    "Users cannot sell the following items on the platform. The below list is not exhaustive and is subject to change at any time by Armoury Broker.",
                    "Prohibited Items include, but are not limited to:" => [
                        "Any item for which the sale or distribution thereof is prohibited by South African law or regulation;",
                        "Unlicensed firearms or firearms without proper transfer documentation under the Firearms Control Act 60 of 2000;",
                        "Ammunition without proper licensing as required by Section 90 of the Firearms Control Act;",
                        "Restricted or prohibited firearms as defined in Section 1 of the Firearms Control Act;", 
                        "Explosive materials or restricted military equipment;", 
                        "Medicines, medical devices, and healthcare products;", 
                        "Motorized vehicles;", 
                        "Counterfeit items, replicas and unauthorized copies;", 
                        "Samples, testers or other promotional items that are not intended for sale;", 
                        "Drop-shipping arrangements;", 
                        "Food and beverages products containing alcohol;", 
                        "Smoking paraphernalia;", 
                        "Offensive material;", 
                        "Adult only material and nudity;", 
                        "Advertisements encouraging purchases outside of the Armoury Broker Platform",
                        "Vouchers, gift cards, digital and non-tangible goods;", 
                        "Drug and drug paraphernalia;", 
                        "Animals;", 
                        "Locked phones",
                    ],
                ],
                "Enforcement and Penalties" => [
                    "Armoury Broker reserves the right to review all transactions and conversations that take place through the platform and suspend and/or remove the account(s) of any user who we deem to be knowingly and willingly selling Prohibited Items through the platform.",
                    "Where Armoury Broker receives a complaint about the selling of Prohibited Items by a seller, it shall investigate such complaint and where necessary suspend the user's account pending conclusion of the investigation.",
                    "Where a user's account is found guilty of knowingly selling Prohibited Items, the user's account may be terminated, all transactions undertaken prior to the termination may be cancelled and the buyers refunded, where applicable.",
                    "Armoury Broker also reserves the right, at its discretion, to provide the account information of any user found guilty of the sale of Prohibited Items to the appropriate authorities or rightful intellectual property owner, on request.",
                ],
            ],
            "Returns and Claims" => [
                "Customer Service and Complaints" => [
                    "If the User has a complaint about the service of Armoury Broker, please contact us at support@armourybroker.co.za and submit your name and contact details, and briefly describe the content of the complaint.",
                    "Armoury Broker will respond to the complaint as soon as possible, but not later than within the next 2 (two) working days, unless specified otherwise.",
                ],
                "Return Rights and Process" => [
                    "If the goods differ significantly from the description given in the sales advertisement or the photo of the product and the Buyer therefore wishes to return the goods to the Seller, the following must be done:" => [
                        "The Buyer must send a message to the Seller and/or Armoury Broker within 48 (forty-eight) hours of receipt of the goods, indicating the discrepancy of the goods from the sales advertisement, and agree on the place and way of returning the goods.",
                        "Firearms Return Restrictions: There is no right of return if it is prohibited by South African law for a particular type of good or if specific firearms legislation prevents the return. Note that firearms transfers must comply with Section 28 of the Firearms Control Act 60 of 2000.",
                        "The right of return cannot be executed if the Buyer has received the goods and confirmed their satisfaction with the goods on the platform or if more than 48 (forty-eight) hours have passed from the receipt of the goods.",
                        "The Buyer undertakes to return the goods in the same condition in which they were received and in compliance with all applicable laws and regulations.",
                        "After the Buyer and the Seller have agreed upon returning the item, the Buyer must return the item within 72 (seventy-two) hours using the same delivery method as was used for initial delivery (courier service, collection, or dealer stocking), unless agreed upon otherwise.",
                        "The funds will remain in Armoury Broker's escrow account until the goods are returned to the Seller. The cost of returning the goods is borne by the Buyer, unless the Seller and the Buyer agree upon otherwise.",
                        "To confirm the return of the goods, the Seller must, within 48 (forty-eight) hours from receiving the goods back from the Buyer, click on the 'Cancel' button on the platform for the specific sales order.",
                        "If the Seller does not cancel the order nor raise any disputes within 48 (forty-eight) hours from receiving the goods back from the Buyer, Armoury Broker reserves the right to cancel the order on behalf of the Seller.",
                        "After the order has been cancelled and funds returned to the Buyer's Armoury Broker wallet, the Buyer can choose between using the funds for future purchases on the platform or paying it out to their chosen South African bank account.",
                    ],
                ],
                "Dispute Resolution Assistance" => [
                    "In the event of unresolvable disputes between the Buyer and the Seller, Armoury Broker may assist in resolving the disputes but is under no obligation to do so and remains an external party to the dispute between the Users.",
                ],
                "Formal Dispute Resolution Process" => [
                    "To resolve disputes between the Buyer and Seller, it is possible to turn to Armoury Broker within 21 (twenty-one) days after submission of the dispute at support@armourybroker.co.za.",
                    "To resolve the dispute between the Seller and the Buyer, Armoury Broker has the right to request additional information from both parties and to use the information on the platform about the communication between the Buyer and the Seller.",
                    "To resolve the disputes as quickly as possible, the Buyer and Seller undertake to actively cooperate and respond to inquiries made by Armoury Broker within 48 (forty-eight) hours.",
                    "If one of the parties to the dispute does not cooperate and does not respond to the submitted requests within 48 (forty-eight) hours, Armoury Broker has the right to make a decision in favor of the other party to the dispute.",
                    "If the Buyer submits a claim for the purchased goods, the Seller must be ready to prove the delivery of the goods by presenting appropriate documentation such as courier tracking information, collection confirmation, or dealer stocking verification.",
                    "If the Seller fails to prove the delivery of the goods through appropriate documentation, Armoury Broker may settle the claim in favor of the other party.",
                    "If the Buyer claims that the goods are not in conformity with the description in the sales advertisement and the Buyer and the Seller do not reach an agreement on the return of the goods, Armoury Broker will decide, based on the available information, in whose favor the claim is settled.",
                ],
                "Claim Resolution Outcomes" => [
                    "The decisions to settle a claim may include:" => [
                        "The claim is settled in favor of the Buyer and the funds are returned to the Buyer's Armoury Broker wallet; the prerequisite of the decision is the return of the goods to the Seller and the Seller's confirmation of receipt of the goods at support@armourybroker.co.za.",
                        "The claim is settled in favor of the Seller and the funds are released to the Seller's Armoury Broker wallet; the Buyer keeps the goods of the claim.",
                        "If the claim cannot be resolved, the funds will remain in Armoury Broker's escrow account until the Buyer and the Seller confirm that they have reached an agreement at support@armourybroker.co.za.",
                        "If, within 1 (one) month, the Buyer and Seller have not reached an agreement, Armoury Broker will decide, based on the available information, the amount of funds returned to the Buyer and/or Seller.",
                        "If an agreement is not reached, the User has the right to turn to the National Consumer Commission (http://www.thencc.gov.za/) when buying goods from an economic or professional trader, or to an appropriate court to resolve the dispute.",
                    ],
                ],
                "Account Closure Following Disputes" => [
                    "After resolving disagreements between Buyer and Seller, Armoury Broker has the right to close the User account, including if:" => [
                        "The User has not fully cooperated with the complaint process;",
                        "It becomes evident that the Seller has confirmed the delivery of goods but has not actually processed the delivery (courier handover, made available for collection, or delivered to dealer) to the Buyer;", 
                        "The Buyer has not paid for the goods despite the conclusion of the purchase agreement;", 
                        "The User has filed an unsubstantiated claim or provided false information;", 
                        "There are repeated complaints about the Seller's goods;", 
                        "There is suspicion of deliberately selling goods that do not correspond to the description;", 
                        "The User has violated firearms legislation or other applicable laws in connection with platform activities.",
                    ],
                ],
            ],
            "Personal Data Processing and Privacy" => [
                "Data Collection" => [
                    "Armoury Broker collects only such personal data from the User that arise during the use of the platform pursuant to the User's activities on the platform.",
                    "Such data includes data in the User's profile, information provided during the sale of a product, and data saved from all other activities provided on the platform.",
                ],
                "Data Processing Rights" => [
                    "Armoury Broker has the right to process data that Armoury Broker has received from the User when registering on the platform and that Armoury Broker has requested during the use of the platform for the purposes and to the extent specified in these Terms.",
                ],
                "Consent and User Rights" => [
                    "The User consents to Armoury Broker processing their personal data for the purposes and to the extent specified in these Terms.",
                    "The User has the right to withdraw the consent at any time, request the termination of the processing of personal data and the deletion or closure of the collected personal data, as well as the closure of the User account.",
                    "The User can request the deletion or closure of the collected personal data by contacting Armoury Broker at support@armourybroker.co.za.",
                ],
                "Purpose of Data Processing" => [
                    "Armoury Broker uses the User's personal data to provide, develop, and personalize the platform's services, ensure compliance with applicable laws including firearms legislation, and maintain the security and integrity of the platform.",
                ],
                "Third-Party Data Sharing" => [
                    "Armoury Broker has the right to use the User's personal data and transfer them to third parties selected by Armoury Broker to cooperate with them to ensure the quality and availability of Armoury Broker services.",
                    "POPIA Compliance: All data processing and sharing complies with the Protection of Personal Information Act 4 of 2013 ('POPIA').",
                ],
                "Payment Processing Data" => [
                    "Armoury Broker transfers the personal data necessary for making payments to its authorized payment processors and other service providers, which process personal data according to the rules prescribed for payment services and in compliance with applicable data protection legislation.",
                ],
                "Data Protection Inquiries" => [
                    "The User always has the right to ask questions related to the processing of the User's personal data by contacting Armoury Broker at support@armourybroker.co.za.",
                    "The User also has the right to contact the Information Regulator of South Africa (enquiries@inforegulator.org.za)."
                ]
            ],
            "Intellectual Property" => [
                "Armoury Broker's Intellectual Property Rights" => [
                    "All website/software layout, website/software content, material, information, data, software, icons, text, graphics, layouts, images, sound clips, advertisements, video clips, user interface design and layout, trade names, logos, trademarks, designs, copyright and/or service marks, together with the underlying software code, are owned by Armoury Broker (Pty) Ltd or licensed to it.",
                    "Such intellectual property is protected from infringement by domestic and international legislation and treaties.",
                ],
                "User Content and Licensing" => [
                    "All rights to any intellectual property the User provides to Armoury Broker will remain with the User, but the User provides Armoury Broker with a revocable, royalty-free, non-exclusive, non-transferable, fully paid license to use such intellectual property to provide Services and for marketing and promotion of the platform.",
                ],
                "User Feedback" => [
                    "If the User provides Armoury Broker with any suggestions, comments or other feedback relating to the platform, such Feedback is provided 'as is' and is deemed as Armoury Broker's sole and exclusive property.",
                    "The User hereby irrevocably assigns to Armoury Broker all of their rights, title and interest in and to all Feedback and waives any moral rights they may have in such Feedback.",
                ],
                "Restrictions on Use" => [
                    "Subject to the rights afforded to Users in these Terms, all other rights to all intellectual property on the platform are expressly reserved.",
                    "The User may not copy, download, print, modify, alter, publish, broadcast, distribute, sell, or transfer any intellectual property without Armoury Broker's written consent."
                ],
                "Platform Modifications" => [
                    "Armoury Broker reserves the right to make improvements or changes to the intellectual property, information, and other materials on the platform, or to suspend or terminate the platform, at any time without notice.",
                ],
                "User License" => [
                    "Subject to adherence to the Terms, Armoury Broker grants to the User a personal, revocable, non-exclusive, non-assignable, non-sublicensable, royalty free, and non-transferable license to use and display all content and information on any machine which the User is the primary user.",
                ]
            ],
            "Amendment of Terms" => [
                "Amendment Rights" => [
                    "Armoury Broker has the right to unilaterally amend these Terms at any time due to the development of the platform and the services offered, changes in applicable legislation, and in the interest of better and safer use.",
                ],
                "Notification of Changes" => [
                    "Armoury Broker undertakes to notify the User of any amendments to these Terms by means of notices, messages, or emails published on the platform or sent to the User's registered email address.",
                ],
                "Effectiveness of Amendments" => [
                    "Amendments to the Terms take effect upon the publication of the corresponding amendment on the platform.",
                ],
                "Acceptance of Amendments" => [
                    "The User confirms their acceptance of the amendments to the Terms by continuing to use the platform after the respective amendments become effective.",
                ]
            ],
            "General Disclaimers" => [
                "Technical Requirements" => [
                    "The platform is only available on compatible devices connected to the internet. It is the User's responsibility to obtain these devices and any connectivity necessary to use the platform.",
                    "Armoury Broker does not guarantee that the platform will function on any particular hardware or device.",
                ],
                "Access Restrictions" => [
                    "Armoury Broker reserves the right to deny the User access to the platform where Armoury Broker believes that the User is in breach of any of these Terms or applicable laws.",
                ],
                '"As Is" Service Provision' => [
                    'The platform and Services are provided "as is" and "as available". Armoury Broker makes no representations or warranties, express or implied, including warranties as to the accuracy, correctness, or suitability of the platform, Services, or information made available through the platform.',
                    "The User's use of the platform is at their sole risk unless otherwise explicitly stated.",
                ],
                "User Content Disclaimer" => [
                    "All content, information, and/or opinions of Users made available on the platform are those of the authors and not Armoury Broker.",
                    "While Armoury Broker makes every reasonable effort to present such information accurately and reliably, it does not endorse, approve, or certify such information.",
                ],
                "Limitation of Liability - Platform Operation" => [
                    "Armoury Broker (Pty) Ltd, its shareholders, directors, employees, and partners, accept no liability whatsoever for any loss, whether direct or indirect, consequential, or arising from information made available on the platform and/or transactions or actions resulting from the platform.",
                ],
                "Limitation of Liability - General" => [
                    "Armoury Broker (Pty) Ltd, its shareholders, directors, employees, partners, and affiliates, accept no liability for any costs, expenses, fines, or damages, including but not limited to direct or indirect loss or damages, data loss, economic loss, consequential loss, loss of profits or any form of punitive damages, resulting from the facilitation and offering of the Services.",
                ],
                "Security Measures" => [
                    "Armoury Broker takes reasonable security measures to ensure the safety and integrity of the platform. However, Armoury Broker does not warrant that the User's access to the platform will be uninterrupted or error-free or that any information will be free of bugs, viruses, or other harmful components."
                ],
            ],
            "Indemnification" => [
                "User Indemnification Obligations" => [
                    "The User agrees to indemnify, defend, and hold harmless Armoury Broker (Pty) Ltd, its shareholders, directors, employees, and partners from any demand, action or application or other proceedings, including for attorneys' fees and related costs, made by any third party, and arising out of or in connection with:" => [
                        "The User's access to or use of the platform;", 
                        "Their violation of these Terms;", 
                        "Their violation of applicable laws (including firearms legislation);",
                        "The infringement by the User of any intellectual property or other right of any person or entity.",
                    ],
                ],
                "Comprehensive Indemnification" => [
                    "The User agrees to indemnify, defend, and hold Armoury Broker harmless from any direct or indirect liability, loss, claim and expense related to the User's use of the platform and/or breach of these Terms.",
                ],
                "Survival of Indemnification" => [
                    "This clause will survive termination of these Terms.",
                ],
            ],
            "Dispute Resolution" => [
                "Amicable Resolution" => [
                    "Should any dispute arise between a User and Armoury Broker concerning the use of the platform, the parties shall endeavor to resolve the dispute amicably, by negotiation.",
                ],
                "Mediation" => [
                    "Should these parties fail to resolve such dispute, the parties will approach an independent industry expert who shall mediate the discussions between them to find a mutually beneficial solution.",
                ],
                "Jurisdiction and Legal Proceedings" => [
                    "If the dispute is still not resolved after such mediation, the parties consent to the non-exclusive jurisdiction of the Magistrates Court of South Africa.",
                    "Either party may also use the dispute resolution services of any applicable legislative tribunal or ombud, as provided for in applicable legislation.",
                ],
                "Confidentiality" => [
                    "The parties both agree that in no circumstance will either party publicize the dispute on any social media or other public platforms.",
                ],
            ],
            "Termination" => [
                "Armoury Broker's Termination Rights" => [
                    "Armoury Broker reserves the right to restrict and/or terminate the User's use of the platform if the User breaches any of these terms, violates applicable laws, or for any other reason in Armoury Broker's sole discretion provided that Armoury Broker gives the user reasonable notice.",
                ],
                "User Termination Rights" => [
                    "If the User wishes to terminate their agreement with Armoury Broker and these Terms, they may do so by ending their use of the platform and deactivating their account.",
                    "Termination will not have any effect on the continued functioning or legitimacy of any lawful rights which the parties may have at the time of said termination.",
                ],
                "Data Handling Upon Termination" => [
                    "In the event of termination of the User's agreement with these Terms, Armoury Broker will remove the User from the platform and delete their account and associated data in accordance with Armoury Broker's data retention policies and applicable data protection legislation.",
                ],
            ],
            "Final Provisions" => [
                "Governing Law" => [
                    "Legal relations between the User and Armoury Broker arising from the use of the platform are governed by the laws of the Republic of South Africa.",
                ],
                "Term and Validity" => [
                    "The Terms and Conditions are valid upon acceptance by the User and will remain in force during the validity of the legal relations between the User and Armoury Broker.",
                ],
                "Electronic Communications" => [
                    "All messages and information between the User and Armoury Broker are exchanged electronically at support@armourybroker.co.za.",
                ],
                "Relationship Between Parties" => [
                    "The relationship of the parties shall be governed by these Terms and nothing contained herein shall be deemed to constitute a partnership, joint venture, employer/employee agreement, agency agreement, or the like between them.",
                    "Armoury Broker only provides software as a service and marketplace functionality; any formal engagement between users facilitated by the platform is between them privately.",
                ],
                "Force Majeure" => [
                    "If either party is prevented from performing any of its duties under these Terms due to an event out of their control (war, political riots, civil commotions, electrical load-shedding, legal prohibitions, epidemics, pandemics, governmental lockdowns, fire, floods or other natural disasters), then such failure shall not constitute a breach under these Terms.",
                ],
                "Amendment Notice" => [
                    "The platform and these Terms are subject to change without notice. The User's continued access or use of the platform constitutes their acceptance to be bound by these Terms, as amended.",
                ],
                "No Waiver" => [
                    "No indulgence, leniency or extension of time granted by Armoury Broker shall constitute a waiver of any of Armoury Broker's rights under these Terms.",
                ],
                "Interpretation" => [
                    "Words importing the singular will include the plural and vice versa. Words importing one gender will include the other genders, and words importing persons will include partnerships, trusts, and bodies corporate.",
                ],
                "Headings" => [
                    "The headings to the paragraphs in these Terms are inserted for reference purposes only and will not affect the interpretation of any of the provisions to which they relate.",
                ]
            ]
        ];
    }

    function renderList($items) {
        $html = "<ol>";
        foreach ($items as $key => $value) {
            if (is_array($value)) {
                $html .= "<li>".($key);
                $html .= $this->renderList($value);
                $html .= "</li>";
            }
            else{
                $html .= "<li>".$value."</li>";
            }
        }
        $html .= "</ol>";
        return $html;

    }

    #[Layout('components.layouts.landing')]
    public function render(){
        $printData = $this->renderList($this->data);
        return view('livewire.landing.terms-conaditions', [
            'printData' => $printData
        ]);
    }
}
